<?xml version="1.0" encoding="iso-8859-1"?>
<!--
 ! Stylesheet for resources page
 !
 ! $Id$
 !-->
<xsl:stylesheet
 version="1.0"
 xmlns:exsl="http://exslt.org/common"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:func="http://exslt.org/functions"
 extension-element-prefixes="func"
>
  <xsl:include href="../layout.xsl"/>
  
  <!--
   ! Template for context navigation
   !
   ! @see      ../../layout.xsl
   ! @purpose  Context navigation
   !-->
  <xsl:template name="context">

    <!-- see also -->
    <h4 class="context">See also</h4>
    <ul class="context">
      <li>
        <em>(qa)</em>:<br/>
        <a href="#qa/feedback">Feedback</a>
      </li>
    </ul>

  </xsl:template>

  <!--
   ! Template for content
   !
   ! @see      ../../layout.xsl
   ! @purpose  Define main content
   !-->
  <xsl:template name="content">
    <h1>about</h1>

    <h3>
      xp explained
    </h3>
    <p>
      The idea of a completely object-oriented framework is not new. Why xp exists, what were
      the reasons and what are the advantages: <a href="#about">Learn more</a>
    </p>

    <h3>
      Into the future
    </h3>
    <p>
      With all of the improvements in PHP5, will xp become? Read about the 
      <a href="#future">future plans for the framework</a>
    </p>

    <h3>
      Further reading 01) Extreme Programming
    </h3>
    <p>
      Extreme Programming (or XP) is a set of values, principles and practices
      for rapidly developing high-quality software that provides the highest
      value for the customer in the fastest way possible. XP is extreme in the
      sense that it takes 12 well-known software development "best practices"
      to their logical extremes -- turning them all up to "10" (or "11" for
      Spinal Tap fans). See <a href="#deref?http://www.jera.com/techinfo/xpfaq.html">Kent Beck's introduction to Extreme Programming Explained<img hspace="2" src="image/arrow.gif" width="11" height="11" border="0"/></a>
      for more details.
    </p>

    <h3>
      Further reading 02) Head-to-Head: PHP vs. ASP.NET
    </h3>
    <p>
      A <a href="#deref?http://msdn.microsoft.com/library/default.asp?url=/library/en-us/dnaspp/html/phpvsaspnet.asp">comparison of PHP4 to the ASP.NET framework<img hspace="2" src="image/arrow.gif" width="11" height="11" border="0"/></a>.
      Although it is definitely true that some features concerning object orientation are not present in PHP4, the
      complaints about a missing class library, consistent naming patterns and the
      missing database abstraction layer are answered here!
    </p>

    <h3>
      Further reading 03) Strong Typing vs. Strong Testing
    </h3>
    <p>
      Bruce Eckel, Author of "Thinking in Java", on <a href="#deref?http://mindview.net/WebLog/log-0025">static vs. dynamic typing<img hspace="2" src="image/arrow.gif" width="11" height="11" border="0"/></a>.
      Altough he is using Python in his article, the arguments made could be 
      adapted to PHP, too.<br/>
      <quote>
        This became a puzzle to me: if strong static type checking is so 
        important, why are people able to build big, complex Python programs 
        (with much shorter time and effort than the strong static 
        counterparts) without the disaster that I was so sure would ensue?
      </quote>
    </p>

    <h3>
      $ whois xp-framework.net
    </h3>
    <p>
      Who is who at the xp framework: <a href="#team">The team</a>
    </p>
  </xsl:template>
  
</xsl:stylesheet>
