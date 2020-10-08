<?php
/**
 * ElasticSearchClient Library
 *
 * @author Pringgo Juni Saputro odyinggo@gmail.com
 * 
 */
class ElasticSearchClient
{
    public function __construct()
    {
        $ci = &get_instance();
        $ci->config->load("elasticsearch_client");
        $this->hosts = $ci->config->item('es_host');
    }

    public function client()
    {
        return Elasticsearch\ClientBuilder::create()
                    ->setHosts($this->hosts)
                    ->build();
    }

}
