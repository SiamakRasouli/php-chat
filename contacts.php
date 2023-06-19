<?php
$query = "SELECT * FROM users WHERE id != :user_id LIMIT 10";
$params = ['user_id' => $_SESSION['user_id']];

$users = $db->query($query, $params)->fetchAll();

?>

<header class="header">
  <span class="show name">Contacts</span>
  <span class="show title"><img src="images/icon_search.png"></span>
  <input type="text" name="search" class="hide">
</header>

<div class="inbox">
  <?php foreach($users as $user) : ?>
  <a href="chat.php?id=<?= $user['id']; ?>" class="chat">
    <div class="avatar">
      <img src="<?= $user['photo']; ?>" alt="" />
    </div>
    <div class="name">
      <span><?= $user['first_name'] . ' ' . $user['last_name']; ?></span>
      <span>You: Hi there.</span>
    </div>
    <div class="info">
      <span>9:41 AM</span>
      <span>3</span>
    </div>
  </a>
  <?php endforeach; ?>
    <hr >

    <div class="form_footer">
      <a href="logout.php">Logout</a>
    </div>
</div>
<!-- Inbox -->

<script>
  var search_icon = document.querySelector('.header span:nth-child(2)');
  var search = document.querySelector('input[name="search"]');
  var header_spans = document.querySelectorAll('.header span');

  search_icon.addEventListener("click", (e) => {
    e.stopPropagation();
    search.value = '';
    search.classList.remove('hide');
    search.classList.add('show');

    header_spans.forEach((key) => {
      key.classList.remove('show');
      key.classList.add('hide');
    });

  });

  document.addEventListener('click', function() {

    search.classList.remove('show');
    search.classList.add('hide');

    header_spans.forEach((key) => {
      key.classList.remove('hide');
      key.classList.add('show');
    });

  });

  search.addEventListener('click', (e) => {
    e.stopPropagation();
  })
</script>

</html>