<?php
header("Content-Type:text/css");
$color1 = $_GET['color1']; // Change your Color Here

function checkhexcolor($color1){
    return preg_match('/^#[a-f0-9]{6}$/i', $color1);
}

if (isset($_GET['color1']) AND $_GET['color1'] != '') {
    $color1 = "#" . $_GET['color1'];
}

if (!$color1 OR !checkhexcolor($color1)) {
    $color1 = "#336699";
}

?>

*::-webkit-scrollbar-button, *::-webkit-scrollbar-thumb, .bg-overlay-main-two:before, .cmn-btn::before, .cmn-btn::after, .custom-btn:hover, #overlayer .loader .loader-inner, ::selection, .section-header .title-border::before, .section-header .title-border::after, .header-top-section .header-add-area .add-left, .header-top-section .header-add-area .add-right, .header-top-section .header-search .header-search-btn, .header-top-section .header-social li a:hover, .header-top-section .header-social li a.active, .mobile-header-right .mobile-header-right-social i, .mobile-header-search .header-search-form .header-search-btn, .header-right-sidebar .payment-site::before, .menu li a i, .pagination .page-item.active .page-link, .banner-slider .swiper-pagination .swiper-pagination-bullet-active, .ruddra-next, .ruddra-prev,.ruddra-next:hover, .ruddra-prev:hover, .service-item::after, .service-details-section .service-details-area .service-bottom-area .service-bottom-item li::before, .add-list-section .add-list-area .add-list-form .add-list-icon i, .add-list-section .add-list-area .add-list-form .nice-select, .add-list-section .add-list-area .add-list-form .payment-list-area .payment-list li .payment-box .form-check input, .add-list-section .add-list-area .add-list-form .submit-btn, .add-list-section .add-list-area .add-list-form .submit-btn--style, .call-to-action-section .call-to-action-form .form-group .submit-btn, .contact-area::before, .contact-form .form-group input[type="submit"], .feature-section .feature-item:hover .title, .event-section .event-area .event-item .title, .express-section .express-area .express-rating-area .pay::before, .express-section .express-area .monitor-area .rating-point, .express-section .express-area .monitor-social-area .monitor-social li .monitor-number span, .express-section .express-area .monitor-feature-area .feature-slider .feature-item .feature-icon, .dashboard-section .dash-item::before, .dashboard-section .dash-item .dash-icon, .deposit-method-section .deposit-method-item .deposit-method-thumb .deposit-method-content, .deposit-table-section .deposit-table thead tr, .deposit-table-section .deposit-table tbody tr td .badge-main, .advertise-section .advertise-area .advertise-item .title, .modal-content .input-group-text, .modal-custom-btn, .input-group-text, .counter-section .counter-item .counter-icon, .close-button, .add-list-form .checkbox-wrapper .checkbox-item input[type="checkbox"]:checked + label::before, .image-upload .thumb .avatar-edit label, .toggle-group .toggle-off, .header-right-sidebar .payment-site .payment-site-list li span {
    background-color: <?= $color1 ?>;
}

.section-header .sub-title, .scrollToTop, .scrollToTop.active, .scrollToTop:hover, .cmn-btn-active,.cmn-btn-active:focus, .cmn-btn-active:hover, .cmn-btn:focus, .cmn-btn:hover, .custom-btn, .trans-btn, .trans-btn:hover, .language-select-list .language-icon i, .header-top-section .header-left-link span i, .menu .list-group-item.active a, .menu .list-group-item .sub-menu li.active a, .menu .list-group-item .sub-menu li.active a i, header .navbar-toggle .toggle-btn, header .navbar-toggle .toggle-btn span, .breadcrumb li, .service-icon i, .add-list-section .add-list-area .add-list-form .submit-btn--style, .add-list-section .add-list-area .terms-and-conditions a, .add-list-section .add-list-area .forgot-password a, .vote-section .vote-area .vote-header-area .title, .contact-icon i::before, .contact-right-area .title, .contact-info-item i, .express-section .express-area .express-rating-area .ratings, .express-section .express-area .monitor-area .monitor-col--style .monitor-thumb-content .title, .express-section .express-area .monitor-area .monitor-list li span, .express-section .express-area .monitor-area .monitor-list li i, .express-section .express-area .insurance-area .insurance-table .insurance-item .insurance-price, .express-section .express-des .title, .express-section-three .express-area .express-item .title, .express-section-three .express-area .express-rating-area .pay, .express-section-three .express-area .monitor-area .rating-point .title, .express-section-three .express-area .monitor-area .rating-point .sub-title, .quality-section .quality-area .quality-header .quality-title .title, .quality-section .quality-area .quality-header .quality-script .title .sub-title, .quality-section-two .quality-area .quality-header .quality-script .title .sub-title, .dashboard-section .dash-item .dash-icon i, .deposit-table-section .deposit-table tbody tr td a:hover, .deposit-table-section .deposit-table tbody tr td::before, .modal-content .close, .forget-pass, .forget-pass:hover {
    color: <?= $color1 ?>;
}

.cmn-btn, .language-select .nice-select, .pagination .page-item.active .page-link, .pagination .page-item:hover .page-link, .file-upload-wrapper:before {
    background: <?= $color1 ?>;
}

#overlayer .loader {
    border: 4px solid <?= $color1 ?>;
}

.header-top-section .header-search input, .header-top-section .header-social li a, .mobile-header-right .mobile-header-right-icon i, .mobile-header-search .search-bar a, .add-list-section .add-list-area .add-list-form .nice-select, .modal-content .input-group-text, .input-group-text {
    border: 1px solid <?= $color1 ?>;
}

.pagination .page-item:hover .page-link, .add-list-form .checkbox-wrapper .checkbox-item input[type="checkbox"]:checked + label::before {
    border-color: <?= $color1 ?>;
}

.client-thumb-two {
    border: 2px solid <?= $color1 ?>;
}

.text-danger {
    color: <?= $color1 ?> !important;
}

#bitcoin {
  background-color: #060b2b;
}

.path {
  stroke: <?= $color1 ?>;
}

@keyframes dash {
  0% {
    stroke-dashoffset: 2110;
    opacity: 0;
    stroke: <?= $color1 ?>;
  }

  15% {
    opacity: 1;
    stroke: <?= $color1 ?>;
  }

  70% {
    opacity: 1;
    stroke: <?= $color1 ?>;
  }

  100% {
    stroke-dashoffset: 0;
    opacity: 0;
    stroke: <?= $color1 ?>;
  }
}