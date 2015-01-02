<?php
if (!isset($session))
{
   $session = mySession::getInstance();
}
?>
<!-- <div id='cssmenu'>
<ul>
   <li><a href='#'><span>Home</span></a></li>
   <li class='active has-sub'><a href='#'><span>Products</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Product 1</span></a>
            <ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li class='last'><a href='#'><span>Sub Product</span></a></li>
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>Product 2</span></a>
            <ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li class='last'><a href='#'><span>Sub Product</span></a></li>
            </ul>
         </li>
      </ul>
   </li>
   <li><a href='#'><span>About</span></a></li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
</ul> 
</div>-->
<div id='cssmenu'>
   <ul>
      <li><a href='/?controller=admin'><span>Admin Home</span></a></li>
      <li class='active has-sub'><a href='#'><span>Data</span></a>
         <ul>
            <li><a href='/?controller=admin&action=individuals'><span>Add or Update Family Info</span></a></li>
            <li class='has-sub'><a href='/?controller=admin&action=upload'><span>Upload Files</span></a>
               <ul>
                  <li><a href='#'><span>Edit Existing</span></a></li>
                  <li class='last'><a href='/?controller=admin&action=upload'><span>Upload New</span></a></li>
               </ul>
            </li>
<!--             <li class='has-sub'><a href='#'><span>Product 2</span></a>
               <ul>
                  <li><a href='#'><span>Sub Product</span></a></li>
                  <li class='last'><a href='#'><span>Sub Product</span></a></li>
               </ul>
            </li> -->
         </ul>
      </li>
      <li class='active has-sub'><a href='/?controller=admin&action=users'><span>Users</span></a>
         <ul>
            <li class='last'><a href='/?controller=admin&action=users'><span>Add or Update Users</span></a></li>
<!--             <li class='has-sub'><a href='#'><span>Product 2</span></a>
               <ul>
                  <li><a href='#'><span>Sub Product</span></a></li>
                  <li class='last'><a href='#'><span>Sub Product</span></a></li>
               </ul>
            </li> -->
         </ul>
      </li>
      <li class='last'><a href='#'><span>Contact</span></a></li>
   </ul>
</div>