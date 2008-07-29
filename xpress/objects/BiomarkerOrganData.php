<?php


class BiomarkerOrganDataVars {
	const OBJID = "objId";
	const SENSITIVITYMIN = "SensitivityMin";
	const SENSITIVITYMAX = "SensitivityMax";
	const SENSITIVITYCOMMENT = "SensitivityComment";
	const SPECIFICITYMIN = "SpecificityMin";
	const SPECIFICITYMAX = "SpecificityMax";
	const SPECIFICITYCOMMENT = "SpecificityComment";
	const PPVMIN = "PPVMin";
	const PPVMAX = "PPVMax";
	const PPVCOMMENT = "PPVComment";
	const NPVMIN = "NPVMin";
	const NPVMAX = "NPVMax";
	const NPVCOMMENT = "NPVComment";
	const QASTATE = "QAState";
	const PHASE = "Phase";
	const DESCRIPTION = "Description";
	const ORGAN = "Organ";
	const BIOMARKER = "Biomarker";
	const RESOURCES = "Resources";
	const PUBLICATIONS = "Publications";
	const STUDYDATAS = "StudyDatas";
}

class BiomarkerOrganDataFactory {
	public static function Create($OrganId,$BiomarkerId){
		$o = new BiomarkerOrganData();
		$o->save();
		$o->link(BiomarkerOrganDataVars::ORGAN,$OrganId,OrganVars::ORGANDATAS);
		$o->link(BiomarkerOrganDataVars::BIOMARKER,$BiomarkerId,BiomarkerVars::ORGANDATAS);
		return $o;
	}
	public static function Retrieve($value,$key = BiomarkerOrganDataVars::OBJID,$fetchStrategy = XPress::FETCH_LOCAL) {
		$o = new BiomarkerOrganData();
		switch ($key) {
			case BiomarkerOrganDataVars::OBJID:
				$o->objId = $value;
				$q = "SELECT * FROM `BiomarkerOrganData` WHERE `objId`=\"{$value}\" LIMIT 1";
				$data = XPress::getInstance()->getDatabase()->getRow($q);
				if (DB::isError($data)) {return false;}
				if (! is_array($data)) {return false;}
				$o->setSensitivityMin($data['SensitivityMin'],false);
				$o->setSensitivityMax($data['SensitivityMax'],false);
				$o->setSensitivityComment($data['SensitivityComment'],false);
				$o->setSpecificityMin($data['SpecificityMin'],false);
				$o->setSpecificityMax($data['SpecificityMax'],false);
				$o->setSpecificityComment($data['SpecificityComment'],false);
				$o->setPPVMin($data['PPVMin'],false);
				$o->setPPVMax($data['PPVMax'],false);
				$o->setPPVComment($data['PPVComment'],false);
				$o->setNPVMin($data['NPVMin'],false);
				$o->setNPVMax($data['NPVMax'],false);
				$o->setNPVComment($data['NPVComment'],false);
				$o->setQAState($data['QAState'],false);
				$o->setPhase($data['Phase'],false);
				$o->setDescription($data['Description'],false);
				return $o;
				break;
			default:
				return false;
				break;
		}
	}
}

class BiomarkerOrganData extends XPressObject {

	const _TYPE = "BiomarkerOrganData";
	public $QAStateEnumValues = array("New","Under Review","Approved","Rejected");
	public $PhaseEnumValues = array("One (1)","Two (2)","Three (3)","Four (4)","Five (5)");
	public $SensitivityMin = '';
	public $SensitivityMax = '';
	public $SensitivityComment = '';
	public $SpecificityMin = '';
	public $SpecificityMax = '';
	public $SpecificityComment = '';
	public $PPVMin = '';
	public $PPVMax = '';
	public $PPVComment = '';
	public $NPVMin = '';
	public $NPVMax = '';
	public $NPVComment = '';
	public $QAState = '';
	public $Phase = '';
	public $Description = '';
	public $Organ = '';
	public $Biomarker = '';
	public $Resources = array();
	public $Publications = array();
	public $StudyDatas = array();


	public function __construct($objId = 0) {
		//echo "creating object of type BiomarkerOrganData<br/>";
		$this->objId = $objId;
	}

	// Accessor Functions
	public function getObjId() {
		 return $this->objId;
	}
	public function getSensitivityMin() {
		 return $this->SensitivityMin;
	}
	public function getSensitivityMax() {
		 return $this->SensitivityMax;
	}
	public function getSensitivityComment() {
		 return $this->SensitivityComment;
	}
	public function getSpecificityMin() {
		 return $this->SpecificityMin;
	}
	public function getSpecificityMax() {
		 return $this->SpecificityMax;
	}
	public function getSpecificityComment() {
		 return $this->SpecificityComment;
	}
	public function getPPVMin() {
		 return $this->PPVMin;
	}
	public function getPPVMax() {
		 return $this->PPVMax;
	}
	public function getPPVComment() {
		 return $this->PPVComment;
	}
	public function getNPVMin() {
		 return $this->NPVMin;
	}
	public function getNPVMax() {
		 return $this->NPVMax;
	}
	public function getNPVComment() {
		 return $this->NPVComment;
	}
	public function getQAState() {
		 return $this->QAState;
	}
	public function getPhase() {
		 return $this->Phase;
	}
	public function getDescription() {
		 return $this->Description;
	}
	public function getOrgan() {
		if ($this->Organ != "") {
			return $this->Organ;
		} else {
			$this->inflate(BiomarkerOrganDataVars::ORGAN);
			return $this->Organ;
		}
	}
	public function getBiomarker() {
		if ($this->Biomarker != "") {
			return $this->Biomarker;
		} else {
			$this->inflate(BiomarkerOrganDataVars::BIOMARKER);
			return $this->Biomarker;
		}
	}
	public function getResources() {
		if ($this->Resources != array()) {
			return $this->Resources;
		} else {
			$this->inflate(BiomarkerOrganDataVars::RESOURCES);
			return $this->Resources;
		}
	}
	public function getPublications() {
		if ($this->Publications != array()) {
			return $this->Publications;
		} else {
			$this->inflate(BiomarkerOrganDataVars::PUBLICATIONS);
			return $this->Publications;
		}
	}
	public function getStudyDatas() {
		if ($this->StudyDatas != array()) {
			return $this->StudyDatas;
		} else {
			$this->inflate(BiomarkerOrganDataVars::STUDYDATAS);
			return $this->StudyDatas;
		}
	}

	// Mutator Functions 
	public function setSensitivityMin($value,$bSave = true) {
		$this->SensitivityMin = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SENSITIVITYMIN);
		}
	}
	public function setSensitivityMax($value,$bSave = true) {
		$this->SensitivityMax = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SENSITIVITYMAX);
		}
	}
	public function setSensitivityComment($value,$bSave = true) {
		$this->SensitivityComment = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SENSITIVITYCOMMENT);
		}
	}
	public function setSpecificityMin($value,$bSave = true) {
		$this->SpecificityMin = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SPECIFICITYMIN);
		}
	}
	public function setSpecificityMax($value,$bSave = true) {
		$this->SpecificityMax = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SPECIFICITYMAX);
		}
	}
	public function setSpecificityComment($value,$bSave = true) {
		$this->SpecificityComment = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::SPECIFICITYCOMMENT);
		}
	}
	public function setPPVMin($value,$bSave = true) {
		$this->PPVMin = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::PPVMIN);
		}
	}
	public function setPPVMax($value,$bSave = true) {
		$this->PPVMax = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::PPVMAX);
		}
	}
	public function setPPVComment($value,$bSave = true) {
		$this->PPVComment = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::PPVCOMMENT);
		}
	}
	public function setNPVMin($value,$bSave = true) {
		$this->NPVMin = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::NPVMIN);
		}
	}
	public function setNPVMax($value,$bSave = true) {
		$this->NPVMax = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::NPVMAX);
		}
	}
	public function setNPVComment($value,$bSave = true) {
		$this->NPVComment = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::NPVCOMMENT);
		}
	}
	public function setQAState($value,$bSave = true) {
		$this->QAState = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::QASTATE);
		}
	}
	public function setPhase($value,$bSave = true) {
		$this->Phase = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::PHASE);
		}
	}
	public function setDescription($value,$bSave = true) {
		$this->Description = $value;
		if ($bSave){
			$this->save(BiomarkerOrganDataVars::DESCRIPTION);
		}
	}

	// API
	private function inflate($variableName) {
		switch ($variableName) {
			case "Biomarker":
				// Inflate "Biomarker":
				$q = "SELECT BiomarkerID AS objId FROM xr_Biomarker_BiomarkerOrganData WHERE BiomarkerOrganDataID = {$this->objId} AND BiomarkerOrganDataVar = \"Biomarker\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				foreach ($ids as $id) {
					$this->Biomarker = BiomarkerFactory::retrieve($id[objId]);
				}
				break;
			case "Organ":
				// Inflate "Organ":
				$q = "SELECT OrganID AS objId FROM xr_BiomarkerOrganData_Organ WHERE BiomarkerOrganDataID = {$this->objId} AND BiomarkerOrganDataVar = \"Organ\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				foreach ($ids as $id) {
					$this->Organ = OrganFactory::retrieve($id[objId]);
				}
				break;
			case "Resources":
				// Inflate "Resources":
				$q = "SELECT ResourceID AS objId FROM xr_BiomarkerOrganData_Resource WHERE BiomarkerOrganDataID = {$this->objId} AND BiomarkerOrganDataVar = \"Resources\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Resources = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Resources[] = ResourceFactory::retrieve($id[objId]);
				}
				break;
			case "Publications":
				// Inflate "Publications":
				$q = "SELECT PublicationID AS objId FROM xr_BiomarkerOrganData_Publication WHERE BiomarkerOrganDataID = {$this->objId} AND BiomarkerOrganDataVar = \"Publications\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->Publications = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->Publications[] = PublicationFactory::retrieve($id[objId]);
				}
				break;
			case "StudyDatas":
				// Inflate "StudyDatas":
				$q = "SELECT BiomarkerOrganStudyDataID AS objId FROM xr_BiomarkerOrganData_BiomarkerOrganStudyData WHERE BiomarkerOrganDataID = {$this->objId} AND BiomarkerOrganDataVar = \"StudyDatas\" ";
				$ids = XPress::getInstance()->getDatabase()->getAll($q);
				$this->StudyDatas = array(); // reset before repopulation to avoid dups
				foreach ($ids as $id) {
					$this->StudyDatas[] = BiomarkerOrganStudyDataFactory::retrieve($id[objId]);
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
		$this->SensitivityMin = '';
		$this->SensitivityMax = '';
		$this->SensitivityComment = '';
		$this->SpecificityMin = '';
		$this->SpecificityMax = '';
		$this->SpecificityComment = '';
		$this->PPVMin = '';
		$this->PPVMax = '';
		$this->PPVComment = '';
		$this->NPVMin = '';
		$this->NPVMax = '';
		$this->NPVComment = '';
		$this->QAState = '';
		$this->Phase = '';
		$this->Description = '';
		$this->Organ = '';
		$this->Biomarker = '';
		$this->Resources = array();
		$this->Publications = array();
		$this->StudyDatas = array();
	}
	public function save($attr = null) {
		if ($this->objId == 0){
			// Insert a new object into the db
			$q = "INSERT INTO `BiomarkerOrganData` ";
			$q .= 'VALUES("","'.$this->SensitivityMin.'","'.$this->SensitivityMax.'","'.$this->SensitivityComment.'","'.$this->SpecificityMin.'","'.$this->SpecificityMax.'","'.$this->SpecificityComment.'","'.$this->PPVMin.'","'.$this->PPVMax.'","'.$this->PPVComment.'","'.$this->NPVMin.'","'.$this->NPVMax.'","'.$this->NPVComment.'","'.$this->QAState.'","'.$this->Phase.'","'.$this->Description.'") ';
			$r = XPress::getInstance()->getDatabase()->query($q);
			$this->objId = XPress::getInstance()->getDatabase()->getOne("SELECT LAST_INSERT_ID() FROM `BiomarkerOrganData`");
		} else {
			if ($attr != null) {
				// Update the given field of an existing object in the db
				$q = "UPDATE `BiomarkerOrganData` SET `{$attr}`=\"{$this->$attr}\" WHERE `objId` = $this->objId";
			} else {
				// Update all fields of an existing object in the db
				$q = "UPDATE `BiomarkerOrganData` SET ";
				$q .= "`objId`=\"{$this->objId}\","; 
				$q .= "`SensitivityMin`=\"{$this->SensitivityMin}\","; 
				$q .= "`SensitivityMax`=\"{$this->SensitivityMax}\","; 
				$q .= "`SensitivityComment`=\"{$this->SensitivityComment}\","; 
				$q .= "`SpecificityMin`=\"{$this->SpecificityMin}\","; 
				$q .= "`SpecificityMax`=\"{$this->SpecificityMax}\","; 
				$q .= "`SpecificityComment`=\"{$this->SpecificityComment}\","; 
				$q .= "`PPVMin`=\"{$this->PPVMin}\","; 
				$q .= "`PPVMax`=\"{$this->PPVMax}\","; 
				$q .= "`PPVComment`=\"{$this->PPVComment}\","; 
				$q .= "`NPVMin`=\"{$this->NPVMin}\","; 
				$q .= "`NPVMax`=\"{$this->NPVMax}\","; 
				$q .= "`NPVComment`=\"{$this->NPVComment}\","; 
				$q .= "`QAState`=\"{$this->QAState}\","; 
				$q .= "`Phase`=\"{$this->Phase}\","; 
				$q .= "`Description`=\"{$this->Description}\" ";
				$q .= "WHERE `objId` = $this->objId ";
			}
			$r = XPress::getInstance()->getDatabase()->query($q);
		}
	}
	public function delete() {
		//Delete this object's child objects

		//Intelligently unlink this object from any other objects
		$this->unlink(BiomarkerOrganDataVars::ORGAN);
		$this->unlink(BiomarkerOrganDataVars::BIOMARKER);
		$this->unlink(BiomarkerOrganDataVars::RESOURCES);
		$this->unlink(BiomarkerOrganDataVars::PUBLICATIONS);
		$this->unlink(BiomarkerOrganDataVars::STUDYDATAS);

		//Signal objects that link to this object to unlink
		// (this covers the case in which a relationship is only 1-directional, where
		// this object has no idea its being pointed to by something)
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Biomarker_BiomarkerOrganData WHERE `BiomarkerOrganDataID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Organ WHERE `BiomarkerOrganDataID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Resource WHERE `BiomarkerOrganDataID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_Publication WHERE `BiomarkerOrganDataID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_BiomarkerOrganData_BiomarkerOrganStudyData WHERE `BiomarkerOrganDataID`={$this->objId}");
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM xr_Study_BiomarkerOrganData WHERE `BiomarkerOrganDataID`={$this->objId}");

		//Delete object from the database
		$r = XPress::getInstance()->getDatabase()->query("DELETE FROM BiomarkerOrganData WHERE `objId` = $this->objId ");
		$this->deflate();
	}
	public function _getType(){
		return BiomarkerOrganData::_TYPE; //BiomarkerOrganData
	}
	public function link($variable,$remoteID,$remoteVar=''){
		switch ($variable){
			case "Biomarker":
				$test = "SELECT COUNT(*) FROM Biomarker WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_Biomarker_BiomarkerOrganData WHERE BiomarkerOrganDataID=$this->objId AND BiomarkerID=$remoteID ";
				$q0 = "INSERT INTO xr_Biomarker_BiomarkerOrganData (BiomarkerOrganDataID,BiomarkerID,BiomarkerOrganDataVar".(($remoteVar == '')? '' : ',BiomarkerVar').") VALUES($this->objId,$remoteID,\"Biomarker\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_Biomarker_BiomarkerOrganData SET BiomarkerOrganDataVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerVar="{$remoteVar}" ')." WHERE BiomarkerOrganDataID=$this->objId AND BiomarkerID=$remoteID LIMIT 1 ";
				break;
			case "Organ":
				$test = "SELECT COUNT(*) FROM Organ WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Organ WHERE BiomarkerOrganDataID=$this->objId AND OrganID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Organ (BiomarkerOrganDataID,OrganID,BiomarkerOrganDataVar".(($remoteVar == '')? '' : ',OrganVar').") VALUES($this->objId,$remoteID,\"Organ\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Organ SET BiomarkerOrganDataVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', OrganVar="{$remoteVar}" ')." WHERE BiomarkerOrganDataID=$this->objId AND OrganID=$remoteID LIMIT 1 ";
				break;
			case "Resources":
				$test = "SELECT COUNT(*) FROM Resource WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Resource WHERE BiomarkerOrganDataID=$this->objId AND ResourceID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Resource (BiomarkerOrganDataID,ResourceID,BiomarkerOrganDataVar".(($remoteVar == '')? '' : ',ResourceVar').") VALUES($this->objId,$remoteID,\"Resources\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Resource SET BiomarkerOrganDataVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', ResourceVar="{$remoteVar}" ')." WHERE BiomarkerOrganDataID=$this->objId AND ResourceID=$remoteID LIMIT 1 ";
				break;
			case "Publications":
				$test = "SELECT COUNT(*) FROM Publication WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_Publication WHERE BiomarkerOrganDataID=$this->objId AND PublicationID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_Publication (BiomarkerOrganDataID,PublicationID,BiomarkerOrganDataVar".(($remoteVar == '')? '' : ',PublicationVar').") VALUES($this->objId,$remoteID,\"Publications\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_Publication SET BiomarkerOrganDataVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', PublicationVar="{$remoteVar}" ')." WHERE BiomarkerOrganDataID=$this->objId AND PublicationID=$remoteID LIMIT 1 ";
				break;
			case "StudyDatas":
				$test = "SELECT COUNT(*) FROM BiomarkerOrganStudyData WHERE objId=\"{$remoteID}\" ";
 				$q  = "SELECT COUNT(*) FROM xr_BiomarkerOrganData_BiomarkerOrganStudyData WHERE BiomarkerOrganDataID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID ";
				$q0 = "INSERT INTO xr_BiomarkerOrganData_BiomarkerOrganStudyData (BiomarkerOrganDataID,BiomarkerOrganStudyDataID,BiomarkerOrganDataVar".(($remoteVar == '')? '' : ',BiomarkerOrganStudyDataVar').") VALUES($this->objId,$remoteID,\"StudyDatas\"".(($remoteVar == '')? '' : ",\"{$remoteVar}\"").");";
				$q1 = "UPDATE xr_BiomarkerOrganData_BiomarkerOrganStudyData SET BiomarkerOrganDataVar=\"{$variable}\" ".(($remoteVar == '')? '' : ', BiomarkerOrganStudyDataVar="{$remoteVar}" ')." WHERE BiomarkerOrganDataID=$this->objId AND BiomarkerOrganStudyDataID=$remoteID LIMIT 1 ";
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
			case "Biomarker":
				$q = "DELETE FROM xr_Biomarker_BiomarkerOrganData WHERE BiomarkerOrganDataID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND BiomarkerOrganDataVar = \"Biomarker\" ";
				break;
			case "Organ":
				$q = "DELETE FROM xr_BiomarkerOrganData_Organ WHERE BiomarkerOrganDataID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND OrganID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND BiomarkerOrganDataVar = \"Organ\" ";
				break;
			case "Resources":
				$q = "DELETE FROM xr_BiomarkerOrganData_Resource WHERE BiomarkerOrganDataID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND ResourceID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND BiomarkerOrganDataVar = \"Resources\" ";
				break;
			case "Publications":
				$q = "DELETE FROM xr_BiomarkerOrganData_Publication WHERE BiomarkerOrganDataID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND PublicationID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND BiomarkerOrganDataVar = \"Publications\" ";
				break;
			case "StudyDatas":
				$q = "DELETE FROM xr_BiomarkerOrganData_BiomarkerOrganStudyData WHERE BiomarkerOrganDataID = $this->objId ".((empty($remoteIDs)) ? '' : (" AND BiomarkerOrganStudyDataID ". ((is_array($remoteIDs))? " IN (".implode(',',$remoteIDs).") . " : " = $remoteIDs "))) ." AND BiomarkerOrganDataVar = \"StudyDatas\" ";
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