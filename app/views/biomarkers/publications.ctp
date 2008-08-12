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
		<a href="/<?php echo PROJROOT;?>/biomarkers/">Biomarkers</a> ::
		<a href="/<?php echo PROJROOT;?>/biomarkers/view/<?php echo $biomarker['Biomarker']['id']?>"><?php echo $biomarker['Biomarker']['name']?> </a> : 
		<span>Publications</span>
		<div class="userdetails">
			<?php if (isset($_SESSION['username'])) {
				echo "Logged in as: {$_SESSION['username']}. &nbsp;";
				echo "<a href=\"/".PROJROOT."/users/logout\">Log Out</a>";
			} else {
				echo "Not Logged In. &nbsp; ";
				echo "<a href=\"/".PROJROOT."/users/login\">Log In</a>";
			}?>
		</div>
	</div><!-- End Breadcrumbs -->
		
	<div id="smalllinks">
		<ul>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/view/<?php echo $biomarker['Biomarker']['id']?>">Basics</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/organs/<?php echo $biomarker['Biomarker']['id']?>">Organs</a></li>
		  <li class=""><a href="/<?php echo PROJROOT;?>/biomarkers/studies/<?php echo $biomarker['Biomarker']['id']?>">Studies</a></li>
		  <li class="activeLink"><a href="/<?php echo PROJROOT;?>/biomarkers/publications/<?php echo $biomarker['Biomarker']['id']?>">Publications</a></li>
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
	<?php echo $biomarker['Biomarker']['modified']?>
</h5>

<h4 style="margin-bottom:0px;margin-left:20px;background-color: transparent;font-size: 18px;">Associated Publications
<div class="editlink">
<span class="fakelink toggle:addstudypub">+ Add a Publication</span>
</div>
</h4>
</h3>
<div id="addstudypub" class="addstudypub" style="display:none;">
	<form action="/<?php echo PROJROOT;?>/biomarkers/addPublication" method="POST">
		<input type="hidden" name="biomarker_id"  value="<?php echo $biomarker['Biomarker']['id']?>"/>
		<input type="hidden" id="publication_id" name="pub_id" value=""/>
		<input type="text" id="publicationsearch" value="" style="width:90%;"/>
		<span class="hint" style="float:left;margin-top:3px;">Begin typing a publication title. A list of options will appear.<br/>
		Don't see the publication you want? <a href="/<?php echo PROJROOT;?>/publications/import">Import a new publication</a></span>
		<input type="button" class="cancelbutton toggle:addstudypub" value="Cancel" style="float:right;padding:2px;margin:6px;margin-right:0px;"/>
		<input type="submit" name="associate_pub" value="Associate" style="float:right;padding:2px;margin:6px;margin-right:0px;"/>
		
	</form>
	<div class="clr"><!-- clear --></div>
</div>
<ul style="margin-left:20px;margin-top:10px;font-size:90%;">
<?php foreach ($biomarker['Publication'] as $publication):?>
	<li><div class="studypubsnippet">
			<a href="#"><?php echo $publication['title']?></a> &nbsp;[<a href="/<?php echo PROJROOT;?>/biomarkers/removePublication/<?php echo $biomarker['Biomarker']['id']?>/<?php echo $publication['id']?>">Remove this association</a>]<br/>
			<span style="color:#555;font-size:90%;">Author:
			<?php echo $publication['author']?>. &nbsp; Published in
			<?php echo $publication['journal']?>, &nbsp;
			<?php echo $publication['published']?></span>
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
     '/<?php echo PROJROOT;?>/biomarkers/ajax_autocompletePublications', {
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
		
			