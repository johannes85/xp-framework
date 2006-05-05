<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses(
    'util.profiling.unittest.TestCase',
    'net.xp_framework.unittest.tests.coverage.PHPCodeFragmentizer'
  );

  /**
   * Tests expression parsing
   *
   * @see      xp://token_get_all
   * @purpose  Unit Test
   */
  class ExpressionTokenizerTest extends TestCase {
    
    /**
     * Retrieve fragments for a given piece of code
     *
     * @see     xp://net.xp_framework.unittest.tests.coverage.PHPCodeFragmentizer
     * @access  protected
     * @param   string code
     * @return  net.xp_framework.unittest.tests.coverage.Fragment[] expressions
     */
    function fragmentsOf($code) {
      return PHPCodeFragmentizer::fragmentsOf('<?php '.trim($code).' ?>');
    }
    
    /**
     * Assert method
     *
     * @access  protected
     * @param   net.xp_framework.unittest.tests.coverage.Fragment[] expected
     * @param   string code
     * @throws  util.profiling.unittest.AssertionFailedError
     */
    function assertExpressions($expected, $code) {
      $fragments= $this->fragmentsOf($code);

      // Compare sizes
      $s= sizeof($fragments);
      if (sizeof($expected) != $s) {
        return $this->fail('Different size', $expected, $fragments);
      }
      
      // Check every element
      for ($i= 0; $i < $s; $i++) {
        if ($fragments[$i]->equals($expected[$i])) continue;

        return $this->fail('At offset #'.$i.'/'.$s, $fragments[$i], $expected[$i]);
      }
    }

    /**
     * Tests empty input will result in an empty array of expressions.
     *
     * @access  public
     */
    #[@test]
    function emptyInput() {
      $this->assertExpressions(array(), '');
    }
    
    /**
     * Tests a single expression
     *
     * @access  public
     */
    #[@test]
    function singleExpression() {
      $this->assertExpressions(array(
        new Expression('$a= 1;', 1, 1),
      ), '$a= 1;');
    }

    /**
     * Tests expression still gets returned even if we have a missing 
     * trailing semicolon (;)
     *
     * @access  public
     */
    #[@test]
    function missingTrailingSemicolon() {
      $this->assertExpressions(array(
        new Expression('$a= 1;', 1, 1),
      ), '$a= 1');
    }

    /**
     * Tests multiple expressions on one line
     *
     * @access  public
     */
    #[@test]
    function multipleExpressionsPerLine() {
      $this->assertExpressions(array(
        new Expression('$a= 1;', 1, 1),
        new Expression('$b= 1;', 1, 1),
      ), '$a= 1; $b= 1;');
    }

    /**
     * Tests an expression spanning multiple lines
     *
     * @access  public
     */
    #[@test]
    function multilineLineExpression() {
      $this->assertExpressions(array(
        new Expression('$a= (5 == strlen("Hello")
          ? "good"
          : "bad"
        );', 1, 4),
      ), '
        $a= (5 == strlen("Hello")
          ? "good"
          : "bad"
        );
      ');
    }

    /**
     * Tests two expressions, each on a line by itself
     *
     * @access  public
     */
    #[@test]
    function twoExpressions() {
      $this->assertExpressions(array(
        new Expression('statement_on_line_one();', 1, 1),
        new Expression('statement_on_line_two();', 2, 2),
      ), '
        statement_on_line_one(); 
        statement_on_line_two();
      ');
    }

    /**
     * Tests a string containing an expression doesn't get torn apart 
     * into expressions.
     *
     * @access  public
     */
    #[@test]
    function stringsContainingExpressions() {
      $this->assertExpressions(array(
        new Expression('echo "A statement: statement_on_line_one();";', 1, 1),
      ), 'echo "A statement: statement_on_line_one();";');
    }
    
    /**
     * Tests a single block
     *
     * @access  public
     */
    #[@test]
    function singleBlock() {
      $this->assertExpressions(array(
        new Block(NULL, array(new Expression('$a= 1;', 1, 1)), 1, 1),
      ), '{ $a= 1; }');
    }

    /**
     * Tests an if block
     *
     * @access  public
     */
    #[@test]
    function ifBlock() {
      $this->assertExpressions(array(
        new Block('if (TRUE)', array(new Expression('exit;', 1, 1)), 1, 1),
      ), 'if (TRUE) { exit; }');
    }

    /**
     * Tests an if / else block
     *
     * @access  public
     */
    #[@test]
    function ifElseBlock() {
      $this->assertExpressions(array(
        new Block('if (TRUE)', array(new Expression('$i++;', 2, 2)), 1, 3),
        new Block('else', array(new Expression('$i--;', 4, 4)), 3, 5),
      ), '
        if (TRUE) { 
          $i++;
        } else {
          $i--;
        }
      ');
    }

    /**
     * Tests a nested blocks
     *
     * @access  public
     */
    #[@test, @ignore('Outer block goes from lines 1 to -1')]
    function nestedBlocks() {
      $this->assertExpressions(array(
        new Block(NULL, array(new Block(NULL, array(new Expression('$a= 1;', 1, 1)), 1, 1)), 1, 1),
      ), '{ { $a= 1; } }');
    }

    /**
     * Tests C++ style comments
     *
     * @access  public
     */
    #[@test]
    function cPlusPlusComment() {
      $this->assertExpressions(
        array(new Comment('/* Hello */', 1, 1)),
        '/* Hello */'
      );
    }

    /**
     * Tests apidoc style comments
     *
     * @access  public
     */
    #[@test]
    function apiDocComment() {
      $comment= "/**\n * APIDOC\n * @return  Should return TRUE\n */";
      $this->assertExpressions(
        array(new Comment($comment, 1, 4)),
        $comment
      );
    }

    /**
     * Tests apidoc style comments
     *
     * @access  public
     */
    #[@test]
    function methodWithApiDocComment() {
      $comment= "/**\n * APIDOC\n * @return  Should return TRUE\n */";
      $method= "function phrickeling() {\n  return TRUE;\n}";
      $this->assertExpressions(array(
        new Comment($comment, 1, 4),
        new Block(
          'function phrickeling()', 
          array(new Expression('return TRUE;', 6, 6)),
          5,
          7
        )
      ), $comment."\n".$method);
    }
  }
?>
