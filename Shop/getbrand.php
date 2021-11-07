<?php
$stmt = $pdo->prepare('SELECT * FROM brand ORDER BY brandname');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header()?>

<div class="recentlyadded">
    <h2>Brands</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
            <span class="name"><?=$product['brandname']?>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>