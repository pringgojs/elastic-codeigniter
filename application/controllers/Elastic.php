<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Elastic extends CI_Controller {

	public $client;
	public function __construct()
	{
		parent::__construct();
		$this->load->library('elasticsearchclient');
		$this->client = $this->elasticsearchclient->client();
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function create_index()
	{
		$params = [
			'index' => 'kendaraan'
		];
		
		$response = $client->indices()->create($params);
		dd($response);
	}

	public function create_index_with_mapping()
	{
		$params = [
			'index' => 'test_index',
			'body' => [
					'settings' => [
							'number_of_shards' => 3,
							'number_of_replicas' => 2
					],
					'mappings' => [
							'_source' => [
									'enabled' => true
							],
							'properties' => [
									'first_name' => [
											'type' => 'keyword'
									],
									'age' => [
											'type' => 'integer'
									]
							]
					]
			]
		];

		$response = $client->indices()->create($params);
		dd($response);
	}

	public function delete_index()
	{
		$params = ['index' => 'test_index'];
		$response = $this->client->indices()->delete($params);
		dd($response);
	}
}
