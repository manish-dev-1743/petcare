<?= $this->extend('include/front') ?>

    <?= $this->section('content'); ?>
    <div class="details-page">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <figure>
                                <img src="<?= '/'.$product['banner_image']; ?>">
                            </figure>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="detail-wrapper">
                                <h2> <?= $product['title'];?></h2>
                                <p class="details">
                                    <?= $product['description']; ?>
                                </p>
                                <div class="amount">
                                    Rs. <?= $product['price'];  ?>
                                </div>
                                <div class="quantity-wrapper">
                                    <div class="increment">+</div>
                                    <div class="quantitiy">1</div>
                                    <div class="decrement">-</div>
                                </div>
                                <div class="button-wrapper">
                                    <a href="#" class="btn">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
    <?= $this->endSection(); ?> 

    <?= $this->section('scripts'); ?>
    <script>
            document.addEventListener('DOMContentLoaded',()=>{
                document.querySelector('.increment').addEventListener('click',()=>{
                    let quantity = document.querySelector('.quantitiy').innerHTML;
                    quantity = parseInt(quantity);
                    quantity = quantity + 1;
                    document.querySelector('.quantitiy').innerHTML = quantity;
                });
                document.querySelector('.decrement').addEventListener('click',()=>{
                    let quantity = document.querySelector('.quantitiy').innerHTML;
                    quantity = parseInt(quantity);
                    if(quantity > 1){
                        quantity = quantity - 1;
                        document.querySelector('.quantitiy').innerHTML = quantity;
                    }
                });
            });
        </script>
    <?= $this->endSection(); ?> 
