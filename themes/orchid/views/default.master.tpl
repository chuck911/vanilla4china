<!DOCTYPE html>
<html>
<head>
  {asset name='Head'}
</head>

<body id="{$BodyID}" class="{$BodyClass}">
<a href="https://github.com/chuck911/vanilla4china" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://vanillaforums.cn/themes/orchid/design/github.png" alt="Fork me on GitHub"></a>
<div id="Frame">
 <div id="Head">
   <div class="Row">
     <strong class="SiteTitle"><a href="{link path="/"}">{logo}</a></strong>
     <ul class="SiteMenu">
      {dashboard_link}
      {discussions_link}
      {activity_link}
      <!-- {inbox_link} -->
      {custom_menu}
      <!-- {profile_link} -->
      {signinout_link}
     </ul>
     <div class="SiteSearch">{searchbox}</div>
   </div>
  </div>
  <div id="Body">
    <div class="Row">
      <div class="Column PanelColumn" id="Panel">
         {module name="MeModule"}
         {asset name="Panel"}
         <div class="Box"><a href=" https://www.digitalocean.com/?refcode=7c6cabf0414a" title="本站部署于DigitalOcean" target="_blank"><img alt="本站部署于DigitalOcean" src="http://square.b0.upaiyun.com//2013/11/23/c831dd38c0304e5d.png"/></a></div>
      </div>
      <div class="Column ContentColumn" id="Content">{asset name="Content"}</div>
    </div>
  </div>
  <div id="Foot">
    <div class="Row">
      <div id="power-by">
      powered by <a href="http://vanillaforums.org/" target="_blank">vanilla forums</a>
      {asset name="Foot"}
      </div>
      <div id="friend-links">
          友情链接：
          <a target="_blank" href="http://aiqingda.com">爱青大BBS</a>
          &nbsp;<a target="_blank" href="http://www.54ux.com/">WP教程网</a>
      </div>
    </div>
  </div>
</div>
{event name="AfterBody"}
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fc2ffd5136ef2ac7f0803dbaa7de208a6' type='text/javascript'%3E%3C/script%3E"));
</script>
</body>
</html>