<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  /**
   * MIME Type
   *
   */
  class MimeType extends Object {
    const
      MIME_APPLICATION_ANDREW_INSET = 'application/andrew-inset',
      MIME_APPLICATION_EXCEL = 'application/excel',
      MIME_APPLICATION_OCTET_STREAM = 'application/octet-stream',
      MIME_APPLICATION_ODA = 'application/oda',
      MIME_APPLICATION_PDF = 'application/pdf',
      MIME_APPLICATION_PGP = 'application/pgp',
      MIME_APPLICATION_POSTSCRIPT = 'application/postscript',
      MIME_APPLICATION_RTF = 'application/rtf',
      MIME_APPLICATION_X_ARJ_COMPRESSED = 'application/x-arj-compressed',
      MIME_APPLICATION_X_BCPIO = 'application/x-bcpio',
      MIME_APPLICATION_X_CHESS_PGN = 'application/x-chess-pgn',
      MIME_APPLICATION_X_CPIO = 'application/x-cpio',
      MIME_APPLICATION_X_CSH = 'application/x-csh',
      MIME_APPLICATION_X_DEBIAN_PACKAGE = 'application/x-debian-package',
      MIME_APPLICATION_X_MSDOS_PROGRAM = 'application/x-msdos-program',
      MIME_APPLICATION_X_DVI = 'application/x-dvi',
      MIME_APPLICATION_X_GTAR = 'application/x-gtar',
      MIME_APPLICATION_X_GUNZIP = 'application/x-gunzip',
      MIME_APPLICATION_X_HDF = 'application/x-hdf',
      MIME_APPLICATION_X_LATEX = 'application/x-latex',
      MIME_APPLICATION_X_MIF = 'application/x-mif',
      MIME_APPLICATION_X_NETCDF = 'application/x-netcdf',
      MIME_APPLICATION_X_PERL = 'application/x-perl',
      MIME_APPLICATION_X_RAR_COMPRESSED = 'application/x-rar-compressed',
      MIME_APPLICATION_X_SH = 'application/x-sh',
      MIME_APPLICATION_X_SHAR = 'application/x-shar',
      MIME_APPLICATION_X_SV = 'application/x-sv',
      MIME_APPLICATION_X_TAR = 'application/x-tar',
      MIME_APPLICATION_X_TAR_GZ = 'application/x-tar-gz',
      MIME_APPLICATION_X_TCL = 'application/x-tcl',
      MIME_APPLICATION_X_TEX = 'application/x-tex',
      MIME_APPLICATION_X_TEXINFO = 'application/x-texinfo',
      MIME_APPLICATION_X_TROFF = 'application/x-troff',
      MIME_APPLICATION_X_TROFF_MAN = 'application/x-troff-man',
      MIME_APPLICATION_X_TROFF_ME = 'application/x-troff-me',
      MIME_APPLICATION_X_TROFF_MS = 'application/x-troff-ms',
      MIME_APPLICATION_X_USTAR = 'application/x-ustar',
      MIME_APPLICATION_X_WAIS_SOURCE = 'application/x-wais-source',
      MIME_APPLICATION_X_ZIP_COMPRESSED = 'application/x-zip-compressed',
      MIME_AUDIO_BASIC = 'audio/basic',
      MIME_AUDIO_MIDI = 'audio/midi',
      MIME_AUDIO_ULAW = 'audio/ulaw',
      MIME_AUDIO_X_AIFF = 'audio/x-aiff',
      MIME_AUDIO_X_WAV = 'audio/x-wav',
      MIME_IMAGE_GIF = 'image/gif',
      MIME_IMAGE_IEF = 'image/ief',
      MIME_IMAGE_JPEG = 'image/jpeg',
      MIME_IMAGE_PNG = 'image/png',
      MIME_IMAGE_TIFF = 'image/tiff',
      MIME_IMAGE_X_CMU_RASTER = 'image/x-cmu-raster',
      MIME_IMAGE_X_PORTABLE_ANYMAP = 'image/x-portable-anymap',
      MIME_IMAGE_X_PORTABLE_BITMAP = 'image/x-portable-bitmap',
      MIME_IMAGE_X_PORTABLE_GRAYMAP = 'image/x-portable-graymap',
      MIME_IMAGE_X_PORTABLE_PIXMAP = 'image/x-portable-pixmap',
      MIME_IMAGE_X_RGB = 'image/x-rgb',
      MIME_IMAGE_X_XBITMAP = 'image/x-xbitmap',
      MIME_IMAGE_X_XPIXMAP = 'image/x-xpixmap',
      MIME_IMAGE_X_XWINDOWDUMP = 'image/x-xwindowdump',
      MIME_TEXT_HTML = 'text/html',
      MIME_TEXT_PLAIN = 'text/plain',
      MIME_TEXT_XML = 'text/xml',
      MIME_TEXT_RICHTEXT = 'text/richtext',
      MIME_TEXT_TAB_SEPARATED_VALUES = 'text/tab-separated-values',
      MIME_TEXT_X_SETEXT = 'text/x-setext',
      MIME_VIDEO_DL = 'video/dl',
      MIME_VIDEO_FLI = 'video/fli',
      MIME_VIDEO_GL = 'video/gl',
      MIME_VIDEO_MPEG = 'video/mpeg',
      MIME_VIDEO_QUICKTIME = 'video/quicktime',
      MIME_VIDEO_X_MSVIDEO = 'video/x-msvideo',
      MIME_VIDEO_X_SGI_MOVIE = 'video/x-sgi-movie',
      MIME_X_WORLD_X_VRML = 'x-world/x-vrml';

  
    /**
     * Get mime type by filename (guess)
     *
     * @access  public
     * @param   string name
     * @param   string default default MIME_APPLICATION_OCTET_STREAM
     * @return  string type
     */
    public function getByFilename($name, $default= MIME_APPLICATION_OCTET_STREAM) {
      static $map= array(
        '.ez'      => MIME_APPLICATION_ANDREW_INSET,
        '.xls'     => MIME_APPLICATION_EXCEL,
        '.bin'     => MIME_APPLICATION_OCTET_STREAM,
        '.oda'     => MIME_APPLICATION_ODA,
        '.pdf'     => MIME_APPLICATION_PDF,
        '.pgp'     => MIME_APPLICATION_PGP,
        '.ps'      => MIME_APPLICATION_POSTSCRIPT,
        '.eps'     => MIME_APPLICATION_POSTSCRIPT,
        '.rtf'     => MIME_APPLICATION_RTF,
        '.arj'     => MIME_APPLICATION_X_ARJ_COMPRESSED,
        '.bcpio'   => MIME_APPLICATION_X_BCPIO,
        '.pgn'     => MIME_APPLICATION_X_CHESS_PGN,
        '.cpio'    => MIME_APPLICATION_X_CPIO,
        '.csh'     => MIME_APPLICATION_X_CSH,
        '.deb'     => MIME_APPLICATION_X_DEBIAN_PACKAGE,
        '.com'     => MIME_APPLICATION_X_MSDOS_PROGRAM,
        '.exe'     => MIME_APPLICATION_X_MSDOS_PROGRAM,
        '.bat'     => MIME_APPLICATION_X_MSDOS_PROGRAM,
        '.dvi'     => MIME_APPLICATION_X_DVI,
        '.gtar'    => MIME_APPLICATION_X_GTAR,
        '.gz'      => MIME_APPLICATION_X_GUNZIP,
        '.hdf'     => MIME_APPLICATION_X_HDF,
        '.latex'   => MIME_APPLICATION_X_LATEX,
        '.mif'     => MIME_APPLICATION_X_MIF,
        '.cdf'     => MIME_APPLICATION_X_NETCDF,
        '.nc'      => MIME_APPLICATION_X_NETCDF,
        '.pl'      => MIME_APPLICATION_X_PERL,
        '.pm'      => MIME_APPLICATION_X_PERL,
        '.rar'     => MIME_APPLICATION_X_RAR_COMPRESSED,
        '.sh'      => MIME_APPLICATION_X_SH,
        '.shar'    => MIME_APPLICATION_X_SHAR,
        '.4cpio'   => MIME_APPLICATION_X_SV,
        '.sv4cpio' => MIME_APPLICATION_X_SV,
        '.4crc'    => MIME_APPLICATION_X_SV,
        '.sv4crc'  => MIME_APPLICATION_X_SV,
        '.tar'     => MIME_APPLICATION_X_TAR,
        '.tgz'     => MIME_APPLICATION_X_TAR_GZ,
        '.tar.gz'  => MIME_APPLICATION_X_TAR_GZ,
        '.tcl'     => MIME_APPLICATION_X_TCL,
        '.tex'     => MIME_APPLICATION_X_TEX,
        '.texi'    => MIME_APPLICATION_X_TEXINFO,
        '.texinfo' => MIME_APPLICATION_X_TEXINFO,
        '.t'       => MIME_APPLICATION_X_TROFF,
        '.tr'      => MIME_APPLICATION_X_TROFF,
        '.roff'    => MIME_APPLICATION_X_TROFF,
        '.man'     => MIME_APPLICATION_X_TROFF_MAN,
        '.me'      => MIME_APPLICATION_X_TROFF_ME,
        '.ms'      => MIME_APPLICATION_X_TROFF_MS,
        '.ustar'   => MIME_APPLICATION_X_USTAR,
        '.src'     => MIME_APPLICATION_X_WAIS_SOURCE,
        '.zip'     => MIME_APPLICATION_X_ZIP_COMPRESSED,
        '.snd'     => MIME_AUDIO_BASIC,
        '.mid'     => MIME_AUDIO_MIDI,
        '.midi'    => MIME_AUDIO_MIDI,
        '.au'      => MIME_AUDIO_ULAW,
        '.aif'     => MIME_AUDIO_X_AIFF,
        '.aifc'    => MIME_AUDIO_X_AIFF,
        '.aiff'    => MIME_AUDIO_X_AIFF,
        '.wav'     => MIME_AUDIO_X_WAV,
        '.gif'     => MIME_IMAGE_GIF,
        '.ief'     => MIME_IMAGE_IEF,
        '.jpe'     => MIME_IMAGE_JPEG,
        '.jpeg'    => MIME_IMAGE_JPEG,
        '.jpg'     => MIME_IMAGE_JPEG,
        '.png'     => MIME_IMAGE_PNG,
        '.tif'     => MIME_IMAGE_TIFF,
        '.tiff'    => MIME_IMAGE_TIFF,
        '.ras'     => MIME_IMAGE_X_CMU_RASTER,
        '.pnm'     => MIME_IMAGE_X_PORTABLE_ANYMAP,
        '.pbm'     => MIME_IMAGE_X_PORTABLE_BITMAP,
        '.pgm'     => MIME_IMAGE_X_PORTABLE_GRAYMAP,
        '.ppm'     => MIME_IMAGE_X_PORTABLE_PIXMAP,
        '.rgb'     => MIME_IMAGE_X_RGB,
        '.xbm'     => MIME_IMAGE_X_XBITMAP,
        '.xpm'     => MIME_IMAGE_X_XPIXMAP,
        '.xwd'     => MIME_IMAGE_X_XWINDOWDUMP,
        '.html'    => MIME_TEXT_HTML,
        '.htm'     => MIME_TEXT_HTML,
        '.asc'     => MIME_TEXT_PLAIN,
        '.txt'     => MIME_TEXT_PLAIN,
        '.ini'     => MIME_TEXT_PLAIN,
        '.conf'    => MIME_TEXT_PLAIN,
        '.xml'     => MIME_TEXT_XML,
        '.xsl'     => MIME_TEXT_XML,
        '.rdf'     => MIME_TEXT_XML,
        '.rss'     => MIME_TEXT_XML,
        '.rtx'     => MIME_TEXT_RICHTEXT,
        '.tsv'     => MIME_TEXT_TAB_SEPARATED_VALUES,
        '.etx'     => MIME_TEXT_X_SETEXT,
        '.dl'      => MIME_VIDEO_DL,
        '.fli'     => MIME_VIDEO_FLI,
        '.gl'      => MIME_VIDEO_GL,
        '.mp2'     => MIME_VIDEO_MPEG,
        '.mpe'     => MIME_VIDEO_MPEG,
        '.mpeg'    => MIME_VIDEO_MPEG,
        '.mpg'     => MIME_VIDEO_MPEG,
        '.mov'     => MIME_VIDEO_QUICKTIME,
        '.qt'      => MIME_VIDEO_QUICKTIME,
        '.avi'     => MIME_VIDEO_X_MSVIDEO,
        '.movie'   => MIME_VIDEO_X_SGI_MOVIE,
        '.vrm'     => MIME_X_WORLD_X_VRML,      
        '.vrml'    => MIME_X_WORLD_X_VRML,      
        '.wrl'     => MIME_X_WORLD_X_VRML,
      );
      
      $parts= explode('.', strtolower($name));
      $i= sizeof($parts)- 1;
      $idx= '';
      
      while ($i > 0 && $idx= $idx.'.'.$parts[$i]) {
        if (isset($map[$idx])) return $map[$idx];
        $i--;
      }
      
      return $default;
    }
  }
?>
