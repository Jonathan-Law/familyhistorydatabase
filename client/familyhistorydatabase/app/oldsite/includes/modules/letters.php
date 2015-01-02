<?php 
if (!isset($session))
{
   $session = mySession::getInstance();
}
?>
<div class="greenlink little text-center" id='minilinks'>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=a";?>">&nbsp;&nbsp;A&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=b";?>">&nbsp;&nbsp;B&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=c";?>">&nbsp;&nbsp;C&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=d";?>">&nbsp;&nbsp;D&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=e";?>">&nbsp;&nbsp;E&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=f";?>">&nbsp;&nbsp;F&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=g";?>">&nbsp;&nbsp;G&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=h";?>">&nbsp;&nbsp;H&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=i";?>">&nbsp;&nbsp;I&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=j";?>">&nbsp;&nbsp;J&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=k";?>">&nbsp;&nbsp;K&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=l";?>">&nbsp;&nbsp;L&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=m";?>">&nbsp;&nbsp;M&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=n";?>">&nbsp;&nbsp;N&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=o";?>">&nbsp;&nbsp;O&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=p";?>">&nbsp;&nbsp;P&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=q";?>">&nbsp;&nbsp;Q&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=r";?>">&nbsp;&nbsp;R&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=s";?>">&nbsp;&nbsp;S&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=t";?>">&nbsp;&nbsp;T&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=u";?>">&nbsp;&nbsp;U&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=v";?>">&nbsp;&nbsp;V&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=w";?>">&nbsp;&nbsp;W&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=x";?>">&nbsp;&nbsp;X&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=y";?>">&nbsp;&nbsp;Y&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=z";?>">&nbsp;&nbsp;Z&nbsp;&nbsp;</a></span>
   <span><a href="<?php echo "/?controller=index&action=".$session->getPage()."&letter=0";?>">&nbsp;&nbsp;#&nbsp;&nbsp;</a></span>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="javascript/jquery.hoverdir.js"></script> 
<script type="text/javascript">
$(function() {

   $(' #da-thumbs > li ').each( function() { $(this).hoverdir(); } );

});
</script>