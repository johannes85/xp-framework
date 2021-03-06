<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'lang.IndexOutOfBoundsException',
    'util.NoSuchElementException',
    'util.collections.HashProvider'
  );

  /**
   * A Last-In-First-Out (LIFO) stack of objects.
   *
   * Example:
   * <code>
   *   uses('util.collections.Stack');
   *   
   *   // Fill stack
   *   with ($s= new Stack()); {
   *     $s->push(new String('One'));
   *     $s->push(new String('Two'));
   *     $s->push(new String('Three'));
   *     $s->push(new String('Four'));
   *   }
   *   
   *   // Empty stack
   *   while (!$s->isEmpty()) {
   *     var_dump($s->pop());
   *   }
   * </code>
   *
   * @purpose  LIFO
   * @see      xp://util.collections.Queue
   * @test     xp://net.xp_framework.unittest.util.collections.GenericsTest
   * @test     xp://net.xp_framework.unittest.util.collections.StackTest
   * @see      http://www.faqs.org/docs/javap/c12/ex-12-1-answer.html
   * @see      http://java.sun.com/j2se/1.4.2/docs/api/java/util/Stack.html 
   */
  #[@generic(self= 'T')]
  class Stack extends Object {
    protected
      $_elements = array(),
      $_hash     = 0;

    /**
     * Pushes an item onto the top of the stack. Returns the element that 
     * was added.
     *
     * @param   T element
     * @return  T
     */
    #[@generic(params= 'T', return= 'T')]
    public function push($element) {
      $h= $element instanceof Generic ? $element->hashCode() : serialize($element);
      array_unshift($this->_elements, $element);
      $this->_hash+= HashProvider::hashOf($h);
      return $element;
    }

    /**
     * Gets an item from the top of the stack
     *
     * @return  T
     * @throws  util.NoSuchElementException
     */    
    #[@generic(return= 'T')]
    public function pop() {
      if (empty($this->_elements)) {
        throw new NoSuchElementException('Stack is empty');
      }
      $element= array_shift($this->_elements);
      $h= $element instanceof Generic ? $element->hashCode() : serialize($element);
      $this->_hash+= HashProvider::hashOf($h);
      return $element;
    }

    /**
     * Peeks at the front of the stack (retrieves the first element 
     * without removing it).
     *
     * Returns NULL in case the stack is empty.
     *
     * @return  T element
     */        
    #[@generic(return= 'T')]
    public function peek() {
      if (empty($this->_elements)) return NULL; else return $this->_elements[0];
    }
  
    /**
     * Returns true if the stack is empty. This is effectively the same
     * as testing size() for 0.
     *
     * @return  bool
     */
    public function isEmpty() {
      return empty($this->_elements);
    }

    /**
     * Returns the size of the stack.
     *
     * @return  int
     */
    public function size() {
      return sizeof($this->_elements);
    }
    
    /**
     * Sees if an object is in the stack and returns its position.
     * Returns -1 if the object is not found.
     *
     * @param   T object
     * @return  int position
     */
    #[@generic(params= 'T')]
    public function search($element) {
      return ($keys= array_keys($this->_elements, $element)) ? $keys[0] : -1;
    }
    
    /**
     * Retrieves an element by its index.
     *
     * @param   int index
     * @return  T
     * @throws  lang.IndexOutOfBoundsException
     */
    #[@generic(return= 'T')]
    public function elementAt($index) {
      if (!isset($this->_elements[$index])) {
        throw new IndexOutOfBoundsException('Index '.$index.' out of bounds');
      }
      return $this->_elements[$index];
    }

    /**
     * Returns a hashcode for this queue
     *
     * @return  string
     */
    public function hashCode() {
      return $this->_hash;
    }
    
    /**
     * Returns true if this queue equals another queue.
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $this->__generic === $cmp->__generic &&
        $this->_hash === $cmp->_hash
      );
    }
  }
?>
