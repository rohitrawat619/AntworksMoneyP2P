<style>
img {
	width: 100%;
	height: 100%;
}
</style>

<section class="sec-pad team-section team-page">
  <div class="container">
    <div class="row" id="post-data">
      <?php
      $this->load->view('frontend/borrower/borrowers-view-ajax');
      ?>
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container --> 
</section>
<div class="ajax-load text-center" style="display:none">
  <p><img src="<?php echo base_url(); ?>assets/img/loader.gif" width="50px"  height="50px">Loading More Borrowers</p>
</div>
<!-- /.sec-pad -->
<!--<script type="text/javascript">-->
<!--  var page = 1;-->
<!--  $(window).scroll(function() {-->
<!--    if($(window).scrollTop() + $(window).height() >= ($(document).height()-400)) {-->
<!--      page++;-->
<!--      loadMoreData(page);-->
<!--    }-->
<!--  });-->
<!---->
<!---->
<!--  function loadMoreData(page){-->
<!--    $.ajax(-->
<!--        {-->
<!--          url: '?page=' + page,-->
<!--          type: "get",-->
<!--          beforeSend: function()-->
<!--          {-->
<!--            $('.ajax-load').show();-->
<!--          }-->
<!--        })-->
<!--        .done(function(data)-->
<!--        {-->
<!--          if(data == " "){-->
<!--            $('.ajax-load').html("No more records found");-->
<!--            return;-->
<!--          }-->
<!--          $('.ajax-load').hide();-->
<!--          $("#post-data").append(data);-->
<!--        })-->
<!--        .fail(function(jqXHR, ajaxOptions, thrownError)-->
<!--        {-->
<!--          alert('server not responding...');-->
<!--        });-->
<!--  }-->
<!--</script>-->