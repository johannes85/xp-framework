<?php namespace net\xp_framework\unittest\text;

use unittest\TestCase;
use text\Tokenizer;


/**
 * Abstract base class for different tokenizer tests
 *
 * @see  xp://text.Tokenizer
 * @see  xp://net.xp_framework.unittest.text.StringTokenizerTest
 * @see  xp://net.xp_framework.unittest.text.StreamTokenizerTest
 */
abstract class AbstractTokenizerTest extends TestCase {

  /**
   * Retrieve a tokenizer instance
   *
   * @param   string source
   * @param   string delimiters default ' '
   * @param   bool returnDelims default FALSE
   * @return  text.Tokenizer
   */
  protected abstract function tokenizerInstance($source, $delimiters= ' ', $returnDelims= false);

  /**
   * Test string tokenizing
   *
   */
  #[@test]
  public function testSimpleString() {
    $t= $this->tokenizerInstance("Hello World!\nThis is an example", " \n");
    $this->assertEquals('Hello', $t->nextToken());
    $this->assertEquals('World!', $t->nextToken());
    $this->assertEquals('This', $t->nextToken());
    $this->assertEquals('is', $t->nextToken());
    $this->assertEquals('an', $t->nextToken());
    $this->assertEquals('example', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens());
  }

  /**
   * Test string tokenizing
   *
   */
  #[@test]
  public function testSimpleStringWithDelims() {
    $t= $this->tokenizerInstance("Hello World!\nThis is an example", " \n", true);
    $this->assertEquals('Hello', $t->nextToken());
    $this->assertEquals(' ', $t->nextToken());
    $this->assertEquals('World!', $t->nextToken());
    $this->assertEquals("\n", $t->nextToken());
    $this->assertEquals('This', $t->nextToken());
    $this->assertEquals(' ', $t->nextToken());
    $this->assertEquals('is', $t->nextToken());
    $this->assertEquals(' ', $t->nextToken());
    $this->assertEquals('an', $t->nextToken());
    $this->assertEquals(' ', $t->nextToken());
    $this->assertEquals('example', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens());
  }
  
  /**
   * Test string tokenizing
   *
   */
  #[@test]
  public function repetetiveDelimiters() {
    $t= $this->tokenizerInstance("Hello \nWorld!", " \n");
    $this->assertEquals('Hello', $t->nextToken());
    $this->assertEquals('', $t->nextToken());
    $this->assertEquals('World!', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens());
  }

  /**
   * Test string tokenizing
   *
   */
  #[@test]
  public function repetetiveDelimitersWithDelims() {
    $t= $this->tokenizerInstance("Hello \nWorld!", " \n", true);
    $this->assertEquals('Hello', $t->nextToken());
    $this->assertEquals(' ', $t->nextToken());
    $this->assertEquals("\n", $t->nextToken());
    $this->assertEquals('World!', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens());
  }
  
  /**
   * Test for loop iteration
   *
   */
  #[@test]
  public function forIteration() {
    $r= array();
    for ($t= $this->tokenizerInstance('A B C', ' '); $t->hasMoreTokens(); ) {
      $r[]= $t->nextToken();
    }
    $this->assertEquals(range('A', 'C'), $r);
  }

  /**
   * Test while loop iteration
   *
   */
  #[@test]
  public function whileIteration() {
    $r= array();
    $t= $this->tokenizerInstance('A B C', ' ');
    while ($t->hasMoreTokens()) {
      $r[]= $t->nextToken();
    }
    $this->assertEquals(range('A', 'C'), $r);
  }

  /**
   * Test foreach() overloading
   *
   */
  #[@test]
  public function foreachIteration() {
    $r= array();
    foreach ($this->tokenizerInstance('A B C', ' ') as $token) {
      $r[]= $token;
    }
    $this->assertEquals(range('A', 'C'), $r);
  }

  /**
   * Test resetting a tokenizer
   *
   */
  #[@test]
  public function reset() {
    $t= $this->tokenizerInstance('A B C', ' ');
    $this->assertTrue($t->hasMoreTokens());
    $this->assertEquals('A', $t->nextToken());
    $t->reset();
    $this->assertTrue($t->hasMoreTokens());
    $this->assertEquals('A', $t->nextToken());
  }

  /**
   * Test pushing back a string with delimiters
   *
   */
  #[@test]
  public function pushBackTokens() {
    $t= $this->tokenizerInstance('1,2,5', ',');
    $this->assertEquals('1', $t->nextToken());
    $this->assertEquals('2', $t->nextToken());
    $t->pushBack('3,4,');
    $this->assertEquals('3', $t->nextToken());
    $this->assertEquals('4', $t->nextToken());
    $this->assertEquals('5', $t->nextToken());
  }

  /**
   * Test pushBack() order
   *
   */
  #[@test]
  public function pushBackOrder() {
    $t= $this->tokenizerInstance('1,2,5', ',');
    $this->assertEquals('1', $t->nextToken());
    $this->assertEquals('2', $t->nextToken());
    $t->pushBack('4,');
    $t->pushBack('3,');
    $this->assertEquals('3', $t->nextToken());
    $this->assertEquals('4', $t->nextToken());
    $this->assertEquals('5', $t->nextToken());
  }

  /**
   * Test pushing back a delimiter
   *
   */
  #[@test]
  public function pushBackDelimiterAtEnd() {
    $t= $this->tokenizerInstance("One\nTwo", "\n");
    $this->assertEquals('One', $t->nextToken());
    $this->assertEquals('Two', $t->nextToken());
    $t->pushBack("Two\n");
    $this->assertEquals('Two', $t->nextToken());
  }

  /**
   * Returns all tokens
   *
   * @param   string input
   * @param   string delim
   * @return  string[] tokens
   */
  protected function allTokens($input, $delim) {
    $t= $this->tokenizerInstance($input, $delim, true);
    $tokens= array();
    while ($t->hasMoreTokens()) {
      $token= $t->nextToken();
      if ('/' === $token) {
        $next= $t->nextToken();
        if ('/' === $next) {
          $token.= $next.$t->nextToken("\n");
        } else {
          $t->pushBack($next);
        }
      }
      $tokens[]= $token;
    }
    return $tokens;
  }

  /**
   * Test pushing back a delimiter
   *
   */
  #[@test]
  public function pushBackDelimiter() {
    $this->assertEquals(
      array('// This is a one-line comment', "\n", 'a', '=', ' ', 'b', ' ', '/', ' ', 'c', ';'),
      $this->allTokens("// This is a one-line comment\na= b / c;", "/\n =;", "/\n =;")
    );
  }

  /**
   * Test pushing back a longer string part which is a regex
   *
   */
  #[@test]
  public function pushBackRegex() {
    $this->assertEquals(
      array('var', ' ', 'pattern', ' ', '=', ' ', '/', '0?([0-9]+)\.0?([0-9]+)(\.0?([0-9]+))?', '/', ';'),
      $this->allTokens('var pattern = /0?([0-9]+)\.0?([0-9]+)(\.0?([0-9]+))?/;', "/\n =;")
    );
  }

  /**
   * Test pushBack()
   *
   */
  #[@test]
  public function pushBackAfterHavingReadUntilEnd() {
    $t= $this->tokenizerInstance('1,2,', ',');
    $this->assertEquals('1', $t->nextToken());
    $this->assertEquals('2', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens(), 'Should be at end');
    $t->pushBack('6,7');
    $this->assertTrue($t->hasMoreTokens(), 'Should have tokens after pushing back');
    $this->assertEquals('6', $t->nextToken(), 'Should yield token pushed back');
    $this->assertEquals('7', $t->nextToken(), 'Should yield token pushed back');
    $this->assertFalse($t->hasMoreTokens(), 'Should be at end again');
  }

  /**
   * Test pushBack()
   *
   */
  #[@test]
  public function pushBackWithDelimitersAfterHavingReadUntilEnd() {
    $t= $this->tokenizerInstance('1,2,', ',', true);
    $this->assertEquals('1', $t->nextToken());
    $this->assertEquals(',', $t->nextToken());
    $this->assertEquals('2', $t->nextToken());
    $this->assertEquals(',', $t->nextToken());
    $this->assertFalse($t->hasMoreTokens(), 'Should be at end');
    $t->pushBack('6,7');
    $this->assertTrue($t->hasMoreTokens(), 'Should have tokens after pushing back');
    $this->assertEquals('6', $t->nextToken(), 'Should yield token pushed back');
    $this->assertEquals(',', $t->nextToken());
    $this->assertEquals('7', $t->nextToken(), 'Should yield token pushed back');
    $this->assertFalse($t->hasMoreTokens(), 'Should be at end again');
  }

  /**
   * Test performance
   *
   */
  #[@test, @ignore('Remove ignore annotation to test performance')]
  public function performance() {
  
    // Create a string with 10000 tokens
    $input= '';
    for ($i= 0; $i < 10000; $i++) {
      $input.= str_repeat('*', rand(0, 76))."\n";
    }
    
    // Tokenize it
    $t= $this->tokenizerInstance($input, "\n", false);
    while ($t->hasMoreTokens()) {
      $token= $t->nextToken();
    }
  }
}
