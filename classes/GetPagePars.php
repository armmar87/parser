<?php


class GetPagePars
{
    public $get_all_pars = array();
    public $contents = array();

    public function
    getParsUrl( $url )
    {

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $file_headers = @get_headers($url);
        if($file_headers[0] == 'HTTP/1.1 200 OK') {
            $doc->loadHTMLFile($url);
        } else {
            return false;
        }
        $doc->preserveWhiteSpace = FALSE;

        $tag_title = $doc->getElementsByTagName('title');
        $tag_a = $doc->getElementsByTagName('a');
//        $this->contents[] = $doc->getElementsByTagName('div');
        $this->contents[] = $tag_a;
        $this->contents[] = $doc->getElementsByTagName('p');
        $this->contents[] = $doc->getElementsByTagName('h1');
        $this->contents[] = $doc->getElementsByTagName('h2');
        $this->contents[] = $doc->getElementsByTagName('h3');
        $this->contents[] = $doc->getElementsByTagName('h4');
        $this->contents[] = $doc->getElementsByTagName('h5');
        $this->contents[] = $doc->getElementsByTagName('h6');

        $this->get_all_pars['url'] = $url;

        $title = '';
        if($tag_title->length > 0){
            $title = $tag_title->item(0)->nodeValue;
        }
        $this->get_all_pars['title'] = $title;

        $content = '';
        $content_length = count($this->contents);
        for ($c = 0; $c < $content_length; $c++) {
            $content .= $this->getPageContains($this->contents[$c], $content);
        }
        $this->get_all_pars['content'] = $content;

        $this->get_all_pars['tree_model'] = htmlentities(file_get_contents($url));


        $uniq_id = uniqid();
        $this->get_all_pars['uniq_id'] = $uniq_id;
        DB::getInstance()->insert('pages', $this->get_all_pars);

        $this->createXmlFile($this->get_all_pars);

/* recursively go through all inner links*/
//        if($tag_a->length > 0){
//            foreach ($tag_a as $element) {
//                $attr_href = $element->getAttribute('href');
//
//                preg_match('@^(?:http://)?([^/]+)@i', $attr_href, $matches1);
//                preg_match('@^(?:http://)?([^/]+)@i', $url, $matches2);
//                $host1 = isset($matches1[1])?$matches1[1]:'';
//                $host2 = isset($matches2[1])?$matches2[1]:'';
//                if(($host1 == $host2) && ($attr_href != $url)) {
//                    $page = new GetPagePars();
//                    $page->getParsUrl($attr_href);
//                }
//            }
//        }


    }

    public function getPageContains($element, $content)
    {
        $element_length = $element->length;
        if($element_length > 0){
            for ($i = 0; $i < $element_length; $i++) {
                $element_value = $element->item($i)->nodeValue;
                if(preg_match('/[^a-zA-Z]+/', $element_value)){
                    $content .= trim($element_value);
                }
            }
        }
        return $content;
    }

    public function createXmlFile($page_contnents)
    {
        $xml = new DOMDocument("1.0". "UTF-8");
        $xml->preserveWhiteSpace = FALSE;

        $container = $xml->createElement("container");
        $container = $xml->appendChild($container);

        $page = $xml->createElement("page");
        $page = $container->appendChild($page);

        $url = $xml->createElement("url", $page_contnents['url']);
        $url = $page->appendChild($url);

        $title = $xml->createElement("title", $page_contnents['title']);
        $title = $page->appendChild($title);

        $content = $xml->createElement("content", $page_contnents['content']);
        $content = $page->appendChild($content);

        $xml->FormatOutput = true;
        $xml->saveXML();
        $xml->save('xml/page_' . $page_contnents['uniq_id'] . '.xml');

    }

}