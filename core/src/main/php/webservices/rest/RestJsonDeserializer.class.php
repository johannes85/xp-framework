<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('webservices.rest.RestDeserializer',  'webservices.json.JsonFactory');

  /**
   * A JSON deserializer
   *
   * @see   xp://webservices.rest.RestDeserializer
   * @test  xp://net.xp_framework.unittest.webservices.rest.RestJsonDeserializerTest
   */
  class RestJsonDeserializer extends RestDeserializer {
    protected $json;

    /**
     * Constructor. Initializes decoder member
     */
    public function __construct() {
      $this->json= JsonFactory::create();
    }

    /**
     * Deserialize
     *
     * @param   io.streams.InputStream in
     * @param   string $encoding
     * @return  var
     * @throws  lang.FormatException
     */
    public function deserialize($in, $encoding= xp::ENCODING) {
      try {
        return $this->json->decodeFrom($in, $encoding);
      } catch (JsonException $e) {
        throw new FormatException('Malformed JSON', $e);
      }
    }
  }
?>
