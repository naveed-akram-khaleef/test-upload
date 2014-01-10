<div class="full_width faq_page">
    <h1><?php print($strHead);?></h1>
	<?php 
        $cnt = 1;
        $rsFAQ = mysql_query("SELECT * FROM faqs ORDER BY faq_id");
        if(mysql_num_rows($rsFAQ)>0){
            while($rowFAQ=mysql_fetch_object($rsFAQ)){
    ?>
        <div class="accord_head expandable collapse"><?php print($cnt.". ".$rowFAQ->faq_question);?></div>
        <div class="accord_contents show"><?php print($rowFAQ->faq_answer);?></div>
    <?php
                $cnt++;
            }
        }
    
    ?>
</div>