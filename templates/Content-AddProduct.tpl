<!-- Content Add Product -->
<!-- One -->
<section id="one">
	<div class="inner">
		<header>
			<h2>Add Products</h2>
			{success}
		</header>
	</div>
</section>

<!-- Two -->
<section id="footer">
	<div class="inner">
		<form method="post" action="addProduct.php" enctype="multipart/form-data">
			<div class="field half first">
				<label for="title">Title</label>
				<input type="text" name="title" id="title" required/>
			</div>
			<div class="field half first">
				<label for="type">Type</label>
				<input type="text" name="type" id="type" required/>
			</div>
			<div class="field half first">
				<label for="color">Color</label>
				<input type="text" name="color" id="color" required />
			</div>
			<div class="field half first">
				<label for="preis">Preis</label>
				<input type="number" min="1" step="any" name="preis" id="preis" required/>
			</div>
			<div class="field half first">
				<label for="img1">Image 1</label>
				<input type="file" id="img1" name="img1" accept="image/*" required>
			</div>
			<div class="field half first">
				<label for="img2">Image 2</label>
				<input type="file" id="img2" name="img2" accept="image/*">
			</div>
			<div class="field half first">
				<label for="img3">Image 3</label>
				<input type="file" id="img3" name="img3" accept="image/*">
			</div>
			<div class="field half first">
				<label for="img4">Image 4</label>
				<input type="file" id="img4" name="img4" accept="image/*">
			</div>
			<div class="field half first">
				<label for="description">Description</label>
				<textarea name="description" id="description" rows="6" required></textarea>
			</div>
			<div style="clear:both;"></div>
			<ul class="actions">
				<li><input type="submit" name="submitAddProduct" value="Add" class="alt" /></li>
			</ul>
		</form>
	</div>
</section>
