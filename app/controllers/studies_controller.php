<?php
class StudiesController extends AppController {
	
	var $helpers = array('Html','Ajax','Javascript','Pagination');
	var $components = array('Pagination');
	var $uses = 
		array(
			'Study',
			'Biomarker',
			'Publication',
			'StudyResource'
		);
	
	/******************************************************************
	 * BROWSE (INDEX)
	 ******************************************************************/
	function index() {
		$this->checkSession("/studies");
		
		$criteria = null;
		$this->Pagination->resultsPerPage = array();
		$this->Pagination->show = 15;
		list($order,$limit,$page) = $this->Pagination->init($criteria);
		$this->set('studies', $this->Study->findAll($criteria,NULL,$order,$limit,$page));
		
		
		// Get a list of all the studies for the ajax search
		$studies = $this->Study->find("all",array('title','id'));
		$studyarr = array();
		foreach ($studies as $study) {
			$studyarr[] = "{$study['Study']['title']}|{$study['Study']['id']}";
		}
		$this->set('studystring','"'.implode("\",\"",$studyarr).'"');
	}
	
	/******************************************************************
	 * BASICS
	 ******************************************************************/
	function view($id = null) {
		$this->checkSession("/studies/view/{$id}");
		$study = $this->Study->find('first',array(
			'conditions' => array('Study.id' => $id),
			'recursive'  => 1
			)
		);
		$this->set('study',$study);
		$this->set('sites',$this->Study->getExtendedSiteDetailsFor($study['Study']['FHCRC_ID']));
	}
	
	function savefield() {
		$data =& $this->params['form'];
		$this->checkSession("/studies/view/{$data['id']}");
		if ($data['object'] == "study") {
			$this->Study->id = $data['id'];
			$this->Study->saveField($data['attr'],$data[$data['attr']]);
			$output = $data[$data['attr']];

		} 
		echo ($output == "") 
			? 'click to edit'
			: $output;
		die(); //prevent layout from being sent >:l
	}
	
	/******************************************************************
	 * PUBLICATIONS
	 ******************************************************************/
	function publications($id = null) {
		$this->checkSession("/studies/publications/{$id}");
		$study = $this->Study->find('first',array(
			'conditions' => array('Study.id' => $id),
			'recursive'  => 1
			)
		);
		$this->set('study',$study);
	}
	
	function addPublication() {
		$data = &$this->params['form'];
		$this->checkSession("/studies/publications/{$data['study_id']}");
		$this->Study->habtmAdd('Publication',$data['study_id'],$data['pub_id']);
		$this->redirect("/studies/publications/{$data['study_id']}");
	}
	
	function removePublication($study_id,$publication_id) {
		$this->checkSession("/studies/publications/{$study_id}");
		$this->Study->habtmDelete('Publication',$study_id,$publication_id);
		$this->redirect("/studies/publications/{$study_id}");
	}
	
	
	/******************************************************************
	 * RESOURCES
	 ******************************************************************/

	function resources($id = null) {
		$this->checkSession("/studies/resources/{$id}");
		$study = $this->Study->find('first',array(
			'conditions' => array('Study.id' => $id),
			'recursive'  => 1
			)
		);
		$this->set('study',$study);
	}
	
	function addResource() {
		$data = &$this->params['form'];
		$this->checkSession("/studies/resources/{$data['study_id']}");
		$this->StudyResource->create(
			array('study_id'=>$data['study_id'],
					'URL'=>$data['url'],
					'description'=>$data['desc']
			)
		);
		$this->StudyResource->save();
		$this->redirect("/studies/resources/{$data['study_id']}");
	}
	
	function removeResource($study_id,$res_id) {
		$this->checkSession("/studies/resources/{$study_id}");
		$this->StudyResource->id = $res_id;
		$this->StudyResource->delete();
		$this->redirect("/studies/resources/{$study_id}");
	}
	
	
	/******************************************************************
	 * AJAX
	 ******************************************************************/
	function ajax_autocompletePublications () {
		$data =& $this->params['form'];
		$needle  = $data['needle'];
		$results = $this->Publication->query("SELECT `title` AS `title`,`id` AS `id` FROM `publications` WHERE `title` LIKE '%{$needle}%'");
		$rstr = '';
		
		foreach ($results as $r) {
			$rstr .= "<li><span id=\"{$r['publications']['id']}\">{$r['publications']['title']}</span></li>";		
		}
		echo ($rstr);
		die();
	}

	/******************************************************************
	 * CREATE (NON_EDRN)
	 ******************************************************************/
	function create() {
		$this->checkSession("/studies/create");
	}
	function createStudy() {
		$this->checkSession("/studies/create");
		if ($this->params['form']) {
			$data = &$this->params['form'];
			if ($data['title'] != '') {
				$this->Study->create(array('title'=>$data['title'],
					'isEDRN'=>0));
				$this->Study->save();
				$id = $this->Study->getLastInsertID();

				$this->redirect("/studies/view/{$id}");
				
			} else {
				$this->set('error',true);
			}
		}
	}
	/******************************************************************
	 * GOTO
	 ******************************************************************/
	function goto() {
		$data = &$this->params['form'];
		if ($data['id']) {
			$this->redirect("/studies/view/{$data['id']}");
		} else {
			$this->redirect("/studies/");
		}
	}

}
?>