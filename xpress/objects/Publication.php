<?php


class PublicationVars {
	const OBJID = "objId";
	const ISPUBMED = "IsPubMed";
	const PUBMEDID = "PubMedID";
	const TITLE = "Title";
	const AUTHOR = "Author";
	const JOURNAL = "Journal";
	const VOLUME = "Volume";
	const ISSUE = "Issue";
	const YEAR = "Year";
	const BIOMARKERS = "Biomarkers";
	const BIOMARKERORGANS = "BiomarkerOrgans";
	const BIOMARKERORGANSTUDIES = "BiomarkerOrganStudies";
	const BIOMARKERSTUDIES = "BiomarkerStudies";
	const STUDIES = "Studies";
}

class PublicationFactory {
	public static function Create($PubMedID){
		$o = new Publication();
		$o->PubMedID = $PubMedID;
		$o->save();
		return $o;
	}
	public static function Retrieve($value,$key = PublicationVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new Publication();
		switch ($key) {
			case PublicationVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `Publication` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setIsPubMed($data['IsPubMed'],false);
				$o->setPubMedID($data['PubMedID'],false);
				$o->setTitle($data['Title'],false);
				$o->setAuthor($data['Author'],false);
				$o->setJournal($data['Journal'],false);
				$o->setVolume($data['Volume'],false);
				$o->setIssue($data['Issue'],false);
				$o->setYear($data['Year'],false);
				return $o;
				break;
			case PublicationVars::PUBMEDID:
				$o->setPubMedID($value,false);
				$q = "SELECT * FROM `Publication` WHERE `PubMedID`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) { return false;}
				if (! is_array($data)) {return false;}
				$o->setobjId($data['objId'],false);
				$o->setIsPubMed($data['IsPubMed'],false);
				$o->setPubMedID($data['PubMedID'],false);
				$o->setTitle($data['Title'],false);
				$o->setAuthor($data['Author'],false);
				$o->setJournal($data['Journal'],false);
				$o->setVolume($data['Volume'],false);
				$o->setIssue($data['Issue'],false);
				$o->setYear($data['Year'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class Publication extends XPressObject {

	const _TYPE = "Publication";
	public $IsPubMed = '';
	public $PubMedID = '';
	public $Title = '';
	public $Author = '';
	public $Journal = '';
	public $Volume = '';
	public $Issue = '';
	public $Year = '';
	public $Biomarkers = array();
	public $BiomarkerOrgans = array();
	public $BiomarkerOrganStudies = array();
	public $BiomarkerStudies = array();
	public $Studies = array();


	public function __construct($objId = 0) {
		//echo "creating object of type Publication<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getIsPubMed() {
		 return $this->IsPubMed;
	}
	public function getPubMedID() {
		 return $this->PubMedID;
	}
	public function getTitle() {
		 return $this->Title;
	}
	public function getAuthor() {
		 return $this->Author;
	}
	public function getJournal() {
		 return $this->Journal;
	}
	public function getVolume() {
		 return $this->Volume;
	}
	public function getIssue() {
		 return $this->Issue;
	}
	public function getYear() {
		 return $this->Year;
	}
	public function getBiomarkers() {
		if ($this->Biomarkers != array()) {
			return $this->Biomarkers;
		} else {
			$this->inflate(PublicationVars::BIOMARKERS);
			return $this->Biomarkers;
		}
	}
	public function getBiomarkerOrgans() {
		if ($this->BiomarkerOrgans != array()) {
			return $this->BiomarkerOrgans;
		} else {
			$this->inflate(PublicationVars::BIOMARKERORGANS);
			return $this->BiomarkerOrgans;
		}
	}
	public function getBiomarkerOrganStudies() {
		if ($this->BiomarkerOrganStudies != array()) {
			return $this->BiomarkerOrganStudies;
		} else {
			$this->inflate(PublicationVars::BIOMARKERORGANSTUDIES);
			return $this->BiomarkerOrganStudies;
		}
	}
	public function getBiomarkerStudies() {
		if ($this->BiomarkerStudies != array()) {
			return $this->BiomarkerStudies;
		} else {
			$this->inflate(PublicationVars::BIOMARKERSTUDIES);
			return $this->BiomarkerStudies;
		}
	}
	public function getStudies() {
		if ($this->Studies != array()) {
			return $this->Studies;
		} else {
			$this->inflate(PublicationVars::STUDIES);
			return $this->Studies;
		}
	}

	// Mutator Functions 
	public function setIsPubMed($value,$bSave = true) {
		$this->IsPubMed = $value;
		if ($bSave){
			$this->save(PublicationVars::ISPUBMED);
		}
	}
	public function setPubMedID($value,$bSave = true) {
		$this->PubMedID = $value;
		if ($bSave){
			$this->save(PublicationVars::PUBMEDID);
		}
	}
	public function setTitle($value,$bSave = true) {
		$this->Title = $value;
		if ($bSave){
			$this->save(PublicationVars::TITLE);
		}
	}
	public function setAuthor($value,$bSave = true) {
		$this->Author = $value;
		if ($bSave){
			$this->save(PublicationVars::AUTHOR);
		}
	}
	public function setJournal($value,$bSave = true) {
		$this->Journal = $value;
		if ($bSave){
			$this->save(PublicationVars::JOURNAL);
		}
	}
	public function setVolume($value,$bSave = true) {
		$this->Volume = $value;
		if ($bSave){
			$this->save(PublicationVars::VOLUME);
		}
	}
	public function setIssue($value,$bSave = true) {
		$this->Issue = $value;
		if ($bSave){
			$this->save(PublicationVars::ISSUE);
		}
	}
	public function setYear($value,$bSave = true) {
		$this->Year = $value;
		if ($bSave){
			$this->save(PublicationVars::YEAR);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Biomarkers":
				// Inflate "Biomarkers":
				$q = "SELECT BiomarkerID AS objId FROM xr_Biomarker_Publication WHERE PublicationID = {$this->objId} AND PublicationVar = \"Biomarkers\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Biomarkers = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Biomarkers[] = BiomarkerFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerStudies":
				// Inflate "BiomarkerStudies":
				$q = "SELECT BiomarkerStudyDataID AS objId FROM xr_BiomarkerStudyData_Publication WHERE PublicationID = {$this->objId} AND PublicationVar = \"BiomarkerStudies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerStudies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerStudies[] = BiomarkerStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrgans":
				// Inflate "BiomarkerOrgans":
				$q = "SELECT BiomarkerOrganDataID AS objId FROM xr_BiomarkerOrganData_Publication WHERE PublicationID = {$this->objId} AND PublicationVar = \"BiomarkerOrgans\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrgans = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrgans[] = BiomarkerOrganDataFactory::retrieve($id[objId]);
				}
				break;
			case "BiomarkerOrganStudies":
				// Inflate "BiomarkerOrganStudies":
				$q = "SELECT BiomarkerOrganStudyDataID AS objId FROM xr_BiomarkerOrganStudyData_Publication WHERE PublicationID = {$this->objId} AND PublicationVar = \"BiomarkerOrganStudies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->BiomarkerOrganStudies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->BiomarkerOrganStudies[] = BiomarkerOrganStudyDataFactory::retrieve($id[objId]);
				}
				break;
			case "Studies":
				// Inflate "Studies":
				$q = "SELECT StudyID AS objId FROM xr_Study_Publication WHERE PublicationID = {$this->objId} AND PublicationVar = \"Studies\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Studies = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Studies[] = StudyFactory::retrieve($id[objId]);
				}
				break;
			default:
				return false;
		}
		return true;
	}
	public function deflate(){
		// reset all member variables to initial settings
		$this->objId = '';
		$this->IsPubMed = '';
		$this->PubMedID = '';
		$this->Title = '';
		$this->Author = '';
		$this->Journal = '';
		$this->Volume = '';
		$this->Issue = '';
		$this->Year = '';
		$this->Biomarkers = array();
		$this->BiomarkerOrgans = array();
		$this->BiomarkerOrganStudies = array();
		$this->BiomarkerStudies = array();
		$this->Studies = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `Publication` ";
			$q .= 'VALUES("","'.$this->IsPubMed.'","'.$this->PubMedID.'","'.$this->Title.'","'.$this->Author.'","'.$this->Journal.'","'.$this->Volume.'","'.$this->Issue.'","'.$this->Year.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `Publication`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `Publication` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `Publication` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`IsPubMed`=\"{$this->IsPubMed}\","; 
				$q .= "`PubMedID`=\"{$this->PubMedID}\","; 
				$q .= "`Title`=\"{$this->Title}\","; 
				$q .= "`Author`=\"{$this->Author}\","; 
				$q .= "`Journal`=\"{$this->Journal}\","; 
				$q .= "`Volume`=\"{$this->Volume}\","; 
				$q .= "`Issue`=\"{$this->Issue}\","; 
				$q .= "`Year`=\"{$this->Year}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects

		//Intelligently unlink this object from any other objects
		$this->unlink(PublicationVars::BIOMARKERS);
		$this->unlink(PublicationVars::BIOMARKERORGANS);
		$this->unlink(PublicationVars::BIOMARKERORGANSTUDIES);
		$this->unlink(PublicationVars::BIOMARKERSTUDIES);
		$this->unlink(PublicationVars::STUDIES);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Biomarker_Publication WHERE `PublicationID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerStudyData_Publication WHERE `PublicationID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Publication WHERE `PublicationID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganStudyData_Publication WHERE `PublicationID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_Publication WHERE `PublicationID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM Publication WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return Publication::_TYPE; //Publication
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Biomarkers":
				$test = "SELECT COUNT(*) FROM Biomarker WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Biomarker_Publication WHERE PublicationID=$this->objId AND BiomarkerID=$remoteID ";
				$q0 = "INSERT INTO xr_Biomarker_Publication (PublicationID,BiomarkerID,PublicationVar".(($remoteVar == '')? '' : ',BiomarkerVar').") VALUES($this->objId,$remoteID,\"Biomarkers\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Biomarker_Publication SET PublicationVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerVar="{$remoteVar}" ')." WHERE PublicationID=$this->objId AND BiomarkerID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerStudies":
				$test = "SELECT COUNT(*) FROM BiomarkerStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerStudyData_Publication WHERE PublicationID=$this->objId AND BiomarkerStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerStudyData_Publication (PublicationID,BiomarkerStudyDataID,PublicationVar".(($remoteVar == '')? '' : ',BiomarkerStudyDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerStudies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerStudyData_Publication SET PublicationVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerStudyDataVar="{$remoteVar}" ')." WHERE PublicationID=$this->objId AND BiomarkerStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrgans":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Publication WHERE PublicationID=$this->objId AND BiomarkerOrganDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Publication (PublicationID,BiomarkerOrganDataID,PublicationVar".(($remoteVar == '')? '' : ',BiomarkerOrganDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrgans\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Publication SET PublicationVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganDataVar="{$remoteVar}" ')." WHERE PublicationID=$this->objId AND BiomarkerOrganDataID=$remoteID LIMIT 1 ";
				break;
			case "BiomarkerOrganStudies":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganStudyData_Publication WHERE PublicationID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganStudyData_Publication (PublicationID,BiomarkerOrganStudyDataID,PublicationVar".(($remoteVar == '')? '' : ',BiomarkerOrganStudyDataVar').") VALUES($this->objId,$remoteID,\"BiomarkerOrganStudies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganStudyData_Publication SET PublicationVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganStudyDataVar="{$remoteVar}" ')." WHERE PublicationID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID LIMIT 1 ";
				break;
			case "Studies":
				$test = "SELECT COUNT(*) FROM Study WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Study_Publication WHERE PublicationID=$this->objId AND StudyID=$remoteID ";
				$q0 = "INSERT INTO xr_Study_Publication (PublicationID,StudyID,PublicationVar".(($remoteVar == '')? '' : ',StudyVar').") VALUES($this->objId,$remoteID,\"Studies\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Study_Publication SET PublicationVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', StudyVar="{$remoteVar}" ')." WHERE PublicationID=$this->objId AND StudyID=$remoteID LIMIT 1 ";
				break;
			default:
				break;
		}
		if (1 != XPress::getInstance()->getDatabase()->getOne($test)) {
			return false; // The requested remote id does not exist!
		}
		$count  = XPress::getInstance()->getDatabase()->getOne($q);
		if ($count == 0){
			XPress::getInstance()->getDatabase()->query($q0);
		} else {
			XPress::getInstance()->getDatabase()->query($q1);
		}
		return true;
	}
	public function unlink($variable,$remoteIDs = ''){
		switch ($variable){
			case "Biomarkers":
				$q = "DELETE FROM xr_Biomarker_Publication WHERE PublicationID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND PublicationVar = \"Biomarkers\" ";
				break;
			case "BiomarkerStudies":
				$q = "DELETE FROM xr_BiomarkerStudyData_Publication WHERE PublicationID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND PublicationVar = \"BiomarkerStudies\" ";
				break;
			case "BiomarkerOrgans":
				$q = "DELETE FROM xr_BiomarkerOrganData_Publication WHERE PublicationID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND PublicationVar = \"BiomarkerOrgans\" ";
				break;
			case "BiomarkerOrganStudies":
				$q = "DELETE FROM xr_BiomarkerOrganStudyData_Publication WHERE PublicationID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND PublicationVar = \"BiomarkerOrganStudies\" ";
				break;
			case "Studies":
				$q = "DELETE FROM xr_Study_Publication WHERE PublicationID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND StudyID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND PublicationVar = \"Studies\" ";
				break;
			default:
				break;
		}
		$r  = XPress::getInstance()->getDatabase()->query($q);
		return true;
	}
	public function equals($objArray){
		if ($objArray == null){return false;}
		//print_r($objArray);
		foreach ($objArray as $obj){
			//echo "::EQUALS:: comparing {$this->_getType()} WITH {$obj->_getType()} &nbsp;<br/>";
			// Check object types first
			if ($this->_getType() == $obj->_getType()){
				// Check objId next
				if ($this->objId != $obj->objId){continue;}
				return true;
			}
		}
		return false;
	}
	public function toJSON(){
		return json_encode($this);
	}
	public function toRDF($namespace,$urlBase) {
		return "";
	}
	public function toRDFStub($namespace,$urlBase) {
		return "";
	}

	// API Extensions 
	// -@-	// -@-
	// End API Extensions --
}

?>