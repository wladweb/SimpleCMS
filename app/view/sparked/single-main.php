<div class="wrapper row4">
  <main id="container" class="clear"> 
    <!-- container body --> 
	<?php $this->get_template('single-sidebar.php'); ?>
    <div id="content" class="three_quarter"> 
      <h1><?=$this->post['title']?></h1>
	  <h3><?=$this->post['subtitle']?></h3>
		<?php $this->get_template('popular_panel.php'); ?>
      <img class="imgr borderedbox pad5" src="/images/<?php echo $this->post['img']?>" alt="">
      <p><?=$this->post['content']?></p>
      <h1>Table(s)</h1>
      <table>
        <thead>
          <tr>
            <th>Header 1</th>
            <th>Header 2</th>
            <th>Header 3</th>
            <th>Header 4</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a href="#">Value 1</a></td>
            <td>Value 2</td>
            <td>Value 3</td>
            <td>Value 4</td>
          </tr>
          <tr>
            <td>Value 5</td>
            <td>Value 6</td>
            <td>Value 7</td>
            <td><a href="#">Value 8</a></td>
          </tr>
          <tr>
            <td>Value 9</td>
            <td>Value 10</td>
            <td>Value 11</td>
            <td>Value 12</td>
          </tr>
          <tr>
            <td>Value 13</td>
            <td><a href="#">Value 14</a></td>
            <td>Value 15</td>
            <td>Value 16</td>
          </tr>
        </tbody>
      </table>
      <div id="comments">
        <?php
			$this->get_comments();
			$this->get_comment_form();
		?>
      </div>
    </div>
    <!-- / container body -->
    <div class="clear"></div>
  </main>
</div>