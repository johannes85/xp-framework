<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.InputStream', 'lang.Closeable');

  /**
   * Serves as an abstract base class for all other readers. A reader
   * returns characters it reads from the underlying InputStream
   * implementation (which works with bytes - for single-byte character
   * sets, there is no difference, obviously).
   */
  abstract class Reader extends Object implements Closeable {
    protected $stream= NULL;
    
    /**
     * Creates a new Reader from an InputStream.
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * Returns the underlying stream
     *
     * @return  io.streams.InputStream stream
     */
    public function getStream() {
      return $this->stream;
    }

    /**
     * Reset to start. 
     *
     * @throws  io.IOException in case the underlying stream does not support seeking
     */
    public function reset() {
      if (!$this->stream instanceof Seekable) {
        throw new IOException('Underlying stream does not support seeking');
      }
      $this->stream->seek(0, SEEK_SET);
    }

    /**
     * Closes this reader (and the underlying stream)
     *
     */
    public function close() {
      $this->stream->close();
    }
  }
?>
