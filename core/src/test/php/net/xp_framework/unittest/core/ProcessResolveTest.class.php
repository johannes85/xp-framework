<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'lang.Process'
  );

  /**
   * TestCase for lang.Process' resolve() method
   *
   * @see      xp://lang.Process
   */
  class ProcessResolveTest extends TestCase {
    protected $origDir= NULL;

    /**
     * Setup test. Verifies this test is for a certain platform
     *
     */
    public function setUp() {
      $this->origDir= getcwd();
    }
    
    /**
     * Tear down test.
     *
     */
    public function tearDown() {
      chdir($this->origDir);
    }

    /**
     * Replaces backslashes in the specified path by the new separator. If $skipDrive is set
     * to TRUE, the leading drive letter definition (e.g. 'C:') is removed from the new path.
     *
     * @param  string  path
     * @param  string  newSeparator
     * @param  bool skipDrive
     * @return string
     */
    private function replaceBackslashSeparator($path, $newSeparator, $skipDrive) {
      $parts= explode('\\', $path);
      if (preg_match('/[a-z]:/i', $parts[0]) != 0 && $skipDrive) array_shift($parts);

      return implode($newSeparator, $parts);
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveFullyQualifiedWithDriverLetter() {
      $this->assertTrue(is_executable(Process::resolve(getenv('WINDIR').'\\EXPLORER.EXE')));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveFullyQualifiedWithDriverLetterWithoutExtension() {
      $this->assertTrue(is_executable(Process::resolve(getenv('WINDIR').'\\EXPLORER')));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveFullyQualifiedWithBackSlash() {
      $path= '\\'.$this->replaceBackslashSeparator(getenv('WINDIR').'\\EXPLORER.EXE', '\\', TRUE);

      chdir('C:');
      $this->assertTrue(is_executable(Process::resolve($path)));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveFullyQualifiedWithSlash() {
      $path= '/'.$this->replaceBackslashSeparator(getenv('WINDIR').'\\EXPLORER.EXE', '/', TRUE);

      chdir('C:');
      $this->assertTrue(is_executable(Process::resolve($path)));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveFullyQualifiedWithoutExtension() {
      $path='\\'.$this->replaceBackslashSeparator(getenv('WINDIR').'\\EXPLORER', '\\', TRUE);

      chdir('C:');
      $this->assertTrue(is_executable(Process::resolve($path)));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveCommandInPath() {
      $this->assertTrue(is_executable(Process::resolve('explorer.exe')));
    }

    /**
     * Test resolving a fully qualified name on Windows
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN'))]
    public function resolveCommandInPathWithoutExtension() {
      $this->assertTrue(is_executable(Process::resolve('explorer')));
    }

    /**
     * Test resolving a non-existant command
     *
     */
    #[@test, @expect('io.IOException')]
    public function resolveSlashDirectory() {
      Process::resolve('/');
    }

    /**
     * Test resolving a non-existant command
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('WIN')), @expect('io.IOException')]
    public function resolveBackslashDirectory() {
      Process::resolve('\\');
    }

    /**
     * Test resolving a non-existant command
     *
     */
    #[@test, @expect('io.IOException')]
    public function resolveEmpty() {
      Process::resolve('');
    }

    /**
     * Test resolving a non-existant command
     *
     */
    #[@test, @expect('io.IOException')]
    public function resolveNonExistant() {
      Process::resolve('@@non-existant@@');
    }

    /**
     * Test resolving a non-existant command
     *
     */
    #[@test, @expect('io.IOException')]
    public function resolveNonExistantFullyQualified() {
      Process::resolve('/@@non-existant@@');
    }

    /**
     * Test resolving a fully qualified name on Posix systems
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('!(WIN|ANDROID)'))]
    public function resolveFullyQualifiedOnPosix() {
      $fq= '/bin/ls';
      $this->assertEquals($fq, Process::resolve($fq));
    }

    /**
     * Test resolving a fully qualified name on Posix systems
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('ANDROID'))]
    public function resolveFullyQualifiedOnAndroid() {
      $fq= getenv('ANDROID_ROOT').'/framework/core.jar';
      $this->assertEquals($fq, Process::resolve($fq));
    }

    /**
     * Test resolving a fully qualified name on Posix systems
     *
     */
    #[@test, @action(class= 'unittest.actions.IsPlatform', args= array('!(WIN|ANDROID)'))]
    public function resolve() {
      $this->assertEquals('/bin/ls', Process::resolve('ls'));
    }
  }
?>
