<?php
/*
 * This class is part of the XP Framework
 *
 */
  uses('util.Observer', 'util.log.Logger');

  /**
   * Profiling database observer
   *
   * Attach to database by appending `&observer[rdbms.ProfilingObserver]=default` where
   * `default` denotes the log category to log to.
   * 
   */
  class ProfilingObserver extends Object implements Observer {
    const COUNT= 0x01;
    const TIMES= 0x02;

    protected $cat  = NULL;
    protected $name = NULL;

    private $timer  = NULL;
    private $lastq  = NULL;
    private $dsn    = NULL;
    private $timing = array();
    
    /**
     * Creates a new log observer with a given log category.
     *
     * @param   string cat
     */
    public function __construct($name= NULL) {
      if (NULL === $name) $name= 'default';
      $this->name= $name;
    }

    protected function typeOf($sql) {
      $sql= strtolower(ltrim($sql));
      $verb= substr($sql, 0, strpos($sql, ' '));

      if (in_array($verb, array('update', 'insert', 'select', 'delete', 'set', 'show'))) {
        return $verb;
      }

      return '<unknown>';
    }

    /**
     * Update method
     *
     * @param   util.Observable obs
     * @param   var arg default NULL
     */
    public function update($obs, $arg= NULL) {
      if (!$obs instanceof DBConnection) {
        throw new IllegalArgumentException('Argument 1 must be instanceof "rdbms.DBConnection", "'.xp::typeOf($obs).'" given.');
      }
      if (!$arg instanceof DBEvent);

      // Store reference for later reuse
      if (NULL === $this->cat) $this->cat= Logger::getInstance()->getCategory($this->name);
      if (NULL === $this->dsn) $this->dsn= $obs->getDSN();

      $method= $arg->getName();
      switch ($method) {
        case 'connect':
        case 'query':
        case 'open': {
          $this->timer= new Timer();
          $this->timer->start();

          $this->lastq= $this->typeOf($arg->getArgument());

          // Count some well-known SQL keywords
          $this->countFor($this->lastq);

          break;
        }

        case 'connected':
        case 'queryend': {
          if (!$this->timer) return;
          $this->timer->stop();

          $this->addElapsedTimeTo($method, $this->timer->elapsedTime());
          if ($this->lastq) {
            $this->addElapsedTimeTo($this->lastq, $this->timer->elapsedTime());
            $this->lastq= NULL;
          }

          $this->timer= NULL;
          break;
        }
      }
    }

    /**
     * Emit recorded timings to LogCategory
     * 
     */
    public function emitTimings() {
      if ($this->cat && $this->dsn) {
        $this->cat->info(__CLASS__, 'for', sprintf('%s://%s@%s/%s',
          $this->dsn->getDriver(),
          $this->dsn->getUser(),
          $this->dsn->getHost(),
          $this->dsn->getDatabase()
          ), $this->timing
        );
      }
    }

    protected function countFor($type) {
      if (!isset($this->timing[$type][self::COUNT])) $this->timing[$type][self::COUNT]= 0;
      $this->timing[$type][self::COUNT]++;
    }

    protected function addElapsedTimeTo($type, $elapsed) {
      if (!isset($this->timing[$type][self::TIMES])) $this->timing[$type][self::TIMES]= 0;
      $this->timing[$type][self::TIMES]+= $elapsed;
    }

    public function numberOfTimes($type) {
      if (!isset($this->timing[$type][self::COUNT])) return 0;
      return $this->timing[$type][self::COUNT];
    }

    public function elapsedTimeOfAll($type) {
      if (!isset($this->timing[$type][self::TIMES])) return 0.0;
      return $this->timing[$type][self::TIMES];
    }

    /** 
     * Destructor; invoke emitTimings() if observer had recorded any activity.
     * 
     */
    public function __destruct() {

      // Check if we're holding a reference to a LogCategory - then update() had been
      // called once, and we probably have something to say
      if ($this->cat) {
        $this->emitTimings();
      }
    }
  }
?>