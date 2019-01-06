<?php
function getDealNameById($id){
    $deal = model('Deal')->get($id);

    echo $deal->name ;

}

function getDealImageById($id){
    $deal = model('Deal')->get($id);
    echo $deal->image;
}

function getCurrentPriceById($id){
    $deal = model('Deal')->get($id);
    echo $deal->current_price;
}
