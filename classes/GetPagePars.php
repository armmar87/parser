<?php


class GetPagePars
{
    public $get_all_pars = array();
    public $contents = array();

    public function getParsUrl($url)
    {

        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTMLFile($url);
        $doc->preserveWhiteSpace = FALSE;


//        $dom = new DOMDocument();
//        $dom->loadHTML($html);
//        $dom->saveHTML();
//        var_dump($html); die;


        $tag_title = $doc->getElementsByTagName('title');
        $this->contents[] = $doc->getElementsByTagName('div');
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

//        $this->get_all_pars['tree_model'] = '333';
        $this->get_all_pars['tree_model'] = $html = file_get_contents($url);


        return $this->get_all_pars;
    }

    public function getPageContains($element, $content)
    {
        $element_length = $element->length;
        if($element_length > 0){
            for ($i = 0; $i < $element_length; $i++) {
                $content .= trim($element->item($i)->nodeValue);
            }
        }
        return $content;
    }

}