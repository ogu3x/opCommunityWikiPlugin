<?php
// vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
/**
 * Code rule end renderer for Xhtml
 *
 * PHP versions 4 and 5
 *
 * @category   Text
 * @package    Text_Wiki
 * @author     Paul M. Jones <pmjones@php.net>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Code.php 206940 2006-02-10 23:07:03Z toggg $
 * @link       http://pear.php.net/package/Text_Wiki
 */

/**
 * This class renders code blocks in XHTML.
 *
 * @category   Text
 * @package    Text_Wiki
 * @author     Paul M. Jones <pmjones@php.net>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Text_Wiki
 */
class Text_Wiki_Render_Xhtml_Code extends Text_Wiki_Render {

    var $conf = array(
        'css'      => null, // class for <pre>
        'css_code' => null, // class for generic <code>
        'css_php'  => null, // class for PHP <code>
        'css_html' => null, // class for HTML <code>
        'css_filename' => null // class for optional filename <div>
    );

    /**
    *
    * Renders a token into text matching the requested format.
    *
    * @access public
    *
    * @param array $options The "options" portion of the token (second
    * element).
    *
    * @return string The text rendered from the token options.
    *
    */

    function token($options)
    {
        $text = $options['text'];
        $attr = $options['attr'];
        $type = strtolower($attr['type']);

        $css      = $this->formatConf(' class="%s"', 'css');
        $css_code = $this->formatConf(' class="%s"', 'css_code');
        $css_php  = $this->formatConf(' class="%s"', 'css_php');
        $css_html = $this->formatConf(' class="%s"', 'css_html');
        $css_filename = $this->formatConf(' class="%s"', 'css_filename');

        $sPattern = array("/<script(\s*)>/i", "/<\/script(\s*)>/i");
        $dPattern = array('&lt;script\1&gt;', '&lt;/script\1&gt;');
        $text = preg_replace($sPattern, $dPattern, $text);

        if ($type == '') {
          $text = '<script type="syntaxhighlighter" class="brush: php;"><![CDATA['.$text.']]></script>';
        } else {
          $text = '<script type="syntaxhighlighter" class="brush: '.$type.';"><![CDATA['.$text.']]></script>';
        }

        if ($css_filename && isset($attr['filename'])) {
            $text = "<div$css_filename>" .
                $attr['filename'] . '</div>' . $text;
        }

//$text = '<div style="border:1px solid #eee">'.$text.'</div>';

        return "\n$text\n\n";
    }
}
?>
