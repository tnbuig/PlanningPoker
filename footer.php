</div><!-- content -->
</div><!-- wrapper -->
<div id="footer">
	 <?php
        if(isset($_SESSION['isFinal'])  && $_SESSION['isFinal'])
        {
			echo '<a class="item" href="final.php"> DO NoT cliCk mE </a>';
		}
		else
		{
			echo '<a class="item" href="final.php"> dO nOT cliCk mE! </a>';
		}
	?>
</div>
</body>
<h3 id="babaText"></h3>
<img id="myImage" onclick="changeImage()" src="images//sheep.png" style="width:150px;height:220px">

<script>
function changeImage() {
    var text = document.getElementById('babaText');
    text.innerHTML = 'Hello friend, my name is Baba, dont be afraid... i am here with you</br> as long as you dont click the button';
}
</script>

</html>