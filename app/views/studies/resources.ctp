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
<?php

?>
<div class="menu">
	<div class="mainContent">
	<h2 class="title">EDRN Biomarker Database</h2>
	</div>
	<!-- Breadcrumbs Area -->
	<div id="breadcrumbs">
		<span style="color:#ddd;">You are here: &nbsp;</span>
		<a href="/<?php echo PROJROOT;?>/">Home</a> :: 
		<a href="/<?php echo PROJROOT;?>/studies/">Studies</a> ::
		<a href="/<?php echo PROJROOT;?>/studies/view/<?php echo $study['Study']['id']?>"><?php echo $study['Study']['title']?> </a> : 
		<span>Resources</span>
	</div><!-- End Breadcrumbs -->
		
	<div id="smalllinks">
		<ul>
		  <li class=""><a href="/<?php echo PROJROOT;?>/studies/view/<?php echo $study['Study']['id']?>">Basics</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/studies/publications/<?php echo $study['Study']['id']?>">Publications</a></li>
		  <li class="activeLink"><a href="/<?php echo PROJROOT;?>/studies/resources/<?php echo $study['Study']['id']?>">Resources</a></li>
		</ul>
		<div class="clr"><!--  --></div>
	</div>
</div>
<div id="outer_wrapper">
<div id="main_section">
<div id="content">
<h2><?php echo $study['Study']['title']?></h2>
<h5 id="urn">urn:edrn:study:<?php echo $study['Study']['FHCRC_ID']?></h5>

<h4 style="margin-bottom:0px;margin-left:20px;background-color: transparent;font-size: 18px;">Associated Resources
	<div class="editlink">
	<span class="fakelink toggle:addstudyres">+ Add a Resource</span>
	</div>
</h4>
<div id="addstudyres" class="addstudyres" style="display:none;">
			<form action="/<?php echo PROJROOT;?>/studies/addResource" method="POST" style="margin-top:5px;">
				<input type="hidden" name="study_id"  value="<?php echo $study['Study']['id']?>"/>
				<div style="float:left;width:90px;color:#555;">URL: &nbsp;&nbsp;http://</div>
				<input type="text" style="width:80%;" name="url"/><br/><br/>
				<div style="float:left;width:90px;color:#555;">Description:</div>
				<input type="text" name="desc" style="float:left;width:50%;"/>
				<input type="submit" name="associate_res" value="Associate" style="float:left;padding:2px;margin-right:0px;margin-left:6px;"/>
				<input type="button" class="cancelbutton toggle:addstudyres" value="Cancel" style="float:left;padding:2px;margin:0px;margin-right:0px;margin-left:6px;"/>
				
			</form>
			<div class="clr"><!-- clear --></div>
		</div>
		<ul style="margin-left:20px;margin-top:10px;font-size:90%;">
			<?php foreach ($study['StudyResource'] as $resource):?>
				<li><div class="studyressnippet">
						<a href="#"><?php echo $resource['URL']?></a>&nbsp;&nbsp;[<a href="/<?php echo PROJROOT;?>/studies/removeResource/<?php echo $study['Study']['id']?>/<?php echo $resource['id']?>">Remove this association</a>]<br/>
						<span style="color:#555;font-size:90%;">
						<?php echo $resource['description']?>
						</span>
					</div>
				</li>
			<?php endforeach;?>
		</ul>



</div>
</div>
</div>

<script type="text/javascript">
  // Activate OrganData Associate Publication autocomplete box
  new Autocompleter.Ajax.Xhtml(
   $('publicationsearch'),
     '/<?php echo PROJROOT;?>/studies/ajax_autocompletePublications', {
     'postData':{'object':'Publication','attr':'Title'},
     'postVar': 'needle',
     'target' : 'publication_id',
     'parseChoices': function(el) {
       var value = el.getFirst().innerHTML;
       var id    = el.getFirst().id;
       el.inputValue = value;
       el.inputId    = id;
       this.addChoiceEvents(el).getFirst().setHTML(this.markQueryValue(value));
     }
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
		
			