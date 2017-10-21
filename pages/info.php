<?php
$content = rex_markdown::factory()->parse($this->i18n('main_content'))." Support-Anfragen koennen entsprechend Ihrem Support-Tarif an ".rex::getErrorEmail()." gesendet werden.<br><br>";
$i=0;

$media = rex_media_category::get(19)->getMedia();
#dump($media);
if (is_array($media)) {
    $content .= '
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
    foreach ($media as $m) {
        if ($m->getValue("type") == "video/mp4") {
            $content .= '
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading'.($i+1).'">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion'.$i.'" href="#collapse" aria-expanded="true" aria-controls="collapse'.$i.'">
          '
          .str_replace('_', ' ', str_replace('.mp4', '', $m->getValue("name"))).
          '
        </a>
      </h4>
    </div>
    <div id="collapse'.$i.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.$i.'">
      <div class="panel-body">
      
          <video width="50%" height="auto" controls preload id="video'.$i.'">
            <source src="'.rex_url::media().$m->getValue("name").'" type="video/mp4">
          Your browser does not support the video tag.
          </video>
          
        '
          .$m->getValue("description")."<br>"
          .rex_formatter::bytes($m->getValue("size"))."<br>"
          .date("Y m",$m->getValue("updatedate"))."<br>"
          .
        '
      </div>
    </div>
            ';
            
        }
$content .= '
</div>
';
$content .= '
';   
    }
}

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('main_title'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');