<?php echo $html->css('frozenobject');?>
<?php echo $html->css('eip');?>
<?php echo $html->css('autocomplete');?>
<?php echo $javascript->link('mootools-release-1.11');?>
<?php echo $javascript->link('eip');?>
<?php echo $javascript->link('autocomplete/Observer');?>
<?php echo $javascript->link('autocomplete/Autocompleter');?>

<?php 
	function printor($value,$alt) {
		if ($value == "") {
			echo $alt;
		} else {
			echo $value;
		}
	}

?>
<div class="menu">
	<div class="mainContent">
	<h2 class="title">EDRN Biomarker Database</h2>
	</div>
	<!-- Breadcrumbs Area -->
	<div id="breadcrumbs">
		<span style="color:#ddd;">You are here: &nbsp;</span>
		<a href="/<?php echo PROJROOT;?>/">Home</a> :: 
		<a href="/<?php echo PROJROOT;?>/biomarkers/">Biomarkers</a> ::
		<a href="/<?php echo PROJROOT;?>/biomarkers/view/<?php echo $biomarker['Biomarker']['id']?>"><?php echo $biomarker['Biomarker']['name']?> </a> : 
		<span>Studies</span>
	</div><!-- End Breadcrumbs -->
		
	<div id="smalllinks">
		<ul>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/view/<?php echo $biomarker['Biomarker']['id']?>">Basics</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/organs/<?php echo $biomarker['Biomarker']['id']?>">Organs</a></li>
		  <li class="activeLink"><a href="/<?php echo PROJROOT;?>/biomarkers/studies/<?php echo $biomarker['Biomarker']['id']?>">Studies</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/publications/<?php echo $biomarker['Biomarker']['id']?>">Publications</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/resources/<?php echo $biomarker['Biomarker']['id']?>">Resources</a></li>
		</ul>
		<div class="clr"><!--  --></div>
	</div>
</div>
<div id="outer_wrapper">
<div id="main_section">
<div id="content">
<h2><?php echo $biomarker['Biomarker']['name']?></h2>
		<h5 id="urn">urn:edrn:biomarker:<?php echo $biomarker['Biomarker']['id']?></h5>
		<h5>Created: <?php echo $biomarker['Biomarker']['created']?>. &nbsp;Last Modified: 
			<?php echo $biomarker['Biomarker']['modified']?></h5>
<h4 style="margin-bottom:0px;margin-left:20px;background-color: transparent;font-size: 18px;">Associated Study Data
<div class="editlink">
<span class="fakelink toggle:addstudydata">+ Add a Study</span>
</div>
</h4>
<div id="addstudydata" class="addstudypub" style="display:none;">
	<form action="/<?php echo PROJROOT;?>/biomarkers/addStudyData" method="POST">
		<input type="hidden" name="biomarker_id"  value="<?php echo $biomarker['Biomarker']['id']?>"/>
		<input type="hidden" id="study_id" name="study_id" value=""/>
		<input type="text" id="study-search" value="" style="width:100%;"/>
		<span class="hint" style="float:left;margin-top:3px;">Begin typing. A list of options will appear.</span>
		<input type="button" class="cancelbutton toggle:addstudydata" value="Cancel" style="float:right;padding:2px;margin:6px;margin-right:-4px;"/>
		<input type="submit" name="associate_study" value="Associate" style="float:right;padding:2px;margin:6px;margin-right:0px;"/>
		
	</form>
	<div class="clr"><!-- clear --></div>
</div>
<?php foreach ($biomarker['BiomarkerStudyData'] as $study):?>
			<h4 style="margin:0px;margin-left:60px;margin-top:15px;padding-top:5px;border-left:solid 1px #ccc;border-top:solid 1px #ccc;"><?php echo $study['Study']['title']?>
				<div class="editlink">
					<a href="/<?php echo PROJROOT;?>/biomarkers/removeStudyData/<?php echo $biomarker['Biomarker']['id']?>/<?php echo $study['id']?>" style="color:#d55;">x Delete</a>	
				</div>	
			</h4>
			<div class="studydetail" style="margin-bottom:15px;">
				<div class="lefttext" style="margin-right:16px;">
					<span id="description" class="textarea"><?php printor(substr($study['Study']['studyAbstract'],0,600).'&nbsp;<a href="/'.PROJROOT.'/studies/view/'.$study['Study']['id'].'" style="text-decoration:underline;font-size:90%;"><em>Click here to read more about this study</em></a>','<em>No Description Provided Yet.</em>');?></span>
				</div>
				<!-- RELEVANT STUDY DATA -->
				<div class="rightcol" style="margin-left:0px;margin-top:0;">
					<h4>Study Results:</h4>
					<table>
						<tr>
							<td class="label">Sensitivity:</td>
							<td><em><span id="sensitivity<?php echo $study['id']?>" class="editable object:study_data id:<?php echo $study['id']?> attr:sensitivity"><?php echo $study['sensitivity']?></span></em>%</td>
						</tr>
						<tr>
							<td class="label">Specificity:</td>
							<td><em><span id="specificity<?php echo $study['id']?>" class="editable object:study_data id:<?php echo $study['id']?> attr:specificity"><?php echo $study['specificity']?></span></em>%</td>
						</tr>
							<tr>
							<td class="label">NPV:</td>
							<td><em><span id="npv<?php echo $study['id']?>" class="editable object:study_data id:<?php echo $study['id']?> attr:npv"><?php echo $study['npv']?></span></em>%</td>
						</tr>
						<tr>
							<td class="label">PPV:</td>
							<td><em><span id="ppv<?php echo $study['id']?>" class="editable object:study_data id:<?php echo $study['id']?> attr:ppv"><?php echo $study['ppv']?></span></em>%</td>
						</tr>
					</table>
					<br/>
					<a style="text-decoration:underline;font-size:90%;" href="/<?php echo PROJROOT;?>/studies/view/<?php echo $study['Study']['id']?>">Go to this study's definition</a>
				</div>
				<div class="clr"><!-- clear --></div>
				<br/>
				<h5 style="position:relative;border-bottom:solid 1px #999;">Related Publications
					<div class="editlink" style="font-size:100%;margin-top:-8px;">
						<span class="fakelink toggle:addstudypub<?php echo $study['id']?>">+ Edit This List</span>
					</div>
				</h5>
				<div id="addstudypub<?php echo $study['id']?>" class="addstudypub" style="margin-left:14px;display:none;">
					<form action="/<?php echo PROJROOT;?>/biomarkers/addBiomarkerStudyDataPub" method="POST">
						<input type="hidden" name="biomarker_id"  value="<?php echo $biomarker['Biomarker']['id']?>"/>
						<input type="hidden" name="study_data_id" value="<?php echo $study['id']?>"/>
						<input type="hidden" id="publication<?php echo $study['id']?>_id" name="pub_id" value=""/>
						<input type="text" class="pubsearch id:<?php echo $study['id']?>" id="publication<?php echo $study['id']?>search" value="" style="width:90%;"/>
						<span class="hint" style="float:left;margin-top:3px;">Begin typing a publication title. A list of options will appear.<br/>
		Don't see the publication you want? <a href="/<?php echo PROJROOT;?>/publications/import">Import a new publication</a></span>
						<input type="button" class="cancelbutton toggle:addstudypub<?php echo $study['id']?>" value="Cancel" style="float:right;padding:2px;margin:6px;margin-right:0px;"/>
						<input type="submit" name="associate_pub" value="Associate" style="float:right;padding:2px;margin:6px;margin-right:0px;"/>
						
					</form>
					<div class="clr"><!-- clear --></div>
				</div>

				<ul style="margin-left:20px;margin-top:10px;font-size:90%;">
				<?php foreach ($study['Publication'] as $publication):?>
					<li><div class="studypubsnippet">
							<a href="#"><?php echo $publication['title']?></a> &nbsp;[<a href="/<?php echo PROJROOT;?>/biomarkers/removeBiomarkerStudyDataPub/<?php echo $biomarker['Biomarker']['id']?>/<?php echo $study['id']?>/<?php echo $publication['id']?>">Remove this association</a>]<br/>
							<span style="color:#555;font-size:90%;">Author:
							<?php echo $publication['author']?>. &nbsp; Published in
							<?php echo $publication['journal']?>, &nbsp;
							<?php echo $publication['published']?></span>
						</div>
					</li>
				<?php endforeach;?>
				</ul>
				
				<br/>
				<h5 style="position:relative;border-bottom:solid 1px #999;">Related Resources
					<div class="editlink" style="font-size:100%;margin-top:-8px;">
						<span class="fakelink toggle:addstudyres<?php echo $study['id']?>">+ Edit This List</span>
					</div>
				</h5>
				<div id="addstudyres<?php echo $study['id']?>" class="addstudyres" style="margin-left:14px;display:none;">
					<form action="/<?php echo PROJROOT;?>/biomarkers/addBiomarkerStudyDataResource" method="POST" style="margin-top:5px;">
						<input type="hidden" name="biomarker_id"  value="<?php echo $biomarker['Biomarker']['id']?>"/>
						<input type="hidden" name="study_data_id" value="<?php echo $study['id']?>"/>
						<div style="float:left;width:90px;color:#555;">URL: &nbsp;&nbsp;http://</div>
						<input type="text" style="width:80%;" name="url"/><br/><br/>
						<div style="float:left;width:90px;color:#555;">Description:</div>
						<input type="text" name="desc" style="float:left;width:50%;"/>
						<input type="submit" name="associate_res" value="Associate" style="float:left;padding:2px;margin-right:0px;margin-left:6px;"/>
						<input type="button" class="cancelbutton toggle:addstudyres<?php echo $study['id']?>" value="Cancel" style="float:left;padding:2px;margin:0px;margin-right:0px;margin-left:6px;"/>
						
					</form>
					<div class="clr"><!-- clear --></div>
				</div>
				
				<ul style="margin-left:20px;margin-top:10px;font-size:90%;">
				<?php foreach ($study['StudyDataResource'] as $resource):?>
					<li><div class="studyressnippet">
							<a href="http://<?php echo $resource['URL']?>"><?php echo $resource['URL']?></a>&nbsp;&nbsp;[<a href="/<?php echo PROJROOT;?>/biomarkers/removeBiomarkerStudyDataResource/<?php echo $biomarker['Biomarker']['id']?>/<?php echo $study['id']?>/<?php echo $resource['id']?>">Remove this association</a>]<br/>
							<span style="color:#555;font-size:90%;">
							<?php echo $resource['description']?>
							</span>
						</div>
					</li>
				<?php endforeach;?>
				</ul>	
			</div>
		<?php endforeach;?>
				

</div>
</div>
</div>
<script type="text/javascript">
  // Activate Edit-in-place text editors
  window.addEvent('domready', function() {
    new eip($$('.editable'), '/<?php echo PROJROOT;?>/biomarkers/savefield', {action: 'update'});
    new eiplist($$('.editablelist'),'/<?php echo PROJROOT;?>/biomarkers/savefield', {action: 'update'});
  });
  
  // Activate Study "Search" Autocomplete
  new Autocompleter.Local(
      $('study-search'),
      <?php
      	echo "[".$studystring."]";
      ?>
	  ,{
      'postData':{'object':'study','attr':'title'},
      'postVar': 'needle',
      'target' : 'study_id',
      'minLength' : 2,
      'parseChoices': function(el) {
        var value = el.getFirst().innerHTML;
        var id    = el.getFirst().id;
        alert(value);
        el.inputValue = value;
        el.inputId    = id;
        this.addChoiceEvents(el).getFirst().setHTML(this.markQueryValue(value));
      },
      'filterTokens': function(token) {
      	var regex = new RegExp('' + this.queryValue.escapeRegExp(), 'i');
      	return this.tokens.filter(function(token) {
          var d = token.split('|');
          return regex.test(d[0]);
        });
      }  
  });
  
  // Activate all BiomarkerStudyData Associate Publication autocomplete boxes
  $$('.pubsearch').each(function(input){
      // Get the id
      var classes = input.getProperty('class').split(" ");
      for (i=classes.length-1;i>=0;i--) {
        if (classes[i].contains('id:')) {
          var id = classes[i].split(":")[1];
        }
      }
      var idval = (id) ? id : '';
      new Autocompleter.Ajax.Xhtml(
        $('publication'+idval+'search'),
          '/<?php echo PROJROOT;?>/biomarkers/ajax_autocompletePublications', {
          'postData':{'object':'Publication','attr':'Title'},
          'postVar': 'needle',
          'target' : 'publication'+idval+'_id',
          'parseChoices': function(el) {
            var value = el.getFirst().innerHTML;
            var id    = el.getFirst().id;
            el.inputValue = value;
            el.inputId    = id;
            this.addChoiceEvents(el).getFirst().setHTML(this.markQueryValue(value));
          }  
       });
    });

   // Activate all Fake Links
   $$('.fakelink').each(function(a){
   	  // Get the id
      var classes = a.getProperty('class').split(" ");
      for (i=classes.length-1;i>=0;i--) {
        if (classes[i].contains('toggle:')) {
          var toggle = classes[i].split(":")[1];
        }
      }
      var toggleval = (toggle) ? toggle : '';
      a.addEvent('click',
        function() {
          if($(toggleval).style.display == 'none') {
            // show
            new Fx.Style(toggleval, 'opacity').set(0);
            $(toggleval).setStyle('display','block');
            $(toggleval).effect('opacity',{duration:400, transition:Fx.Transitions.linear}).start(0,1);
          } else {
            // hide
            $(toggleval).effect('opacity',{
              duration:200, 
              transition:Fx.Transitions.linear,onComplete:function(){
                $(toggleval).setStyle('display','none');
              }
            }).start(1,0);
          }
      });
   });
   
   // Activate all Cancel Buttons 
   $$('.cancelbutton').each(function(a){
   	  // Get the id
      var classes = a.getProperty('class').split(" ");
      for (i=classes.length-1;i>=0;i--) {
        if (classes[i].contains('toggle:')) {
          var toggle = classes[i].split(":")[1];
        }
      }
      var toggleval = (toggle) ? toggle : '';
      a.addEvent('click',
        function() {
          if($(toggleval).style.display == 'none') {
            // show
            new Fx.Style(toggleval, 'opacity').set(0);
            $(toggleval).setStyle('display','block');
            $(toggleval).effect('opacity',{duration:400, transition:Fx.Transitions.linear}).start(0,1);
          } else {
            // hide
            $(toggleval).effect('opacity',{
              duration:200, 
              transition:Fx.Transitions.linear,onComplete:function(){
                $(toggleval).setStyle('display','none');
              }
            }).start(1,0);
          }
      });
   });

</script>