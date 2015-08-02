
<?php if(!empty($alert['msg'])){ ?>
    <div class="alert alert-<?php echo (!empty($alert['type']))?$alert['type']:'info'; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $alert['msg'];?>
    </div>
<?php }?>

<div class="page-header">
    <h1 class="text-info"><?php echo $title ?></h1>
</div>

<div class="row">
    <div class="col-md-offset-8 col-md-4 text-right lead">
        <a class="btn btn-primary" href="<?php echo $this->config->base_url(); ?>index.php/news/edit">Create News</a>
    </div>
</div>

<table class="table table-striped table-hover table-condensed">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Text</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if(!empty($news)): ?>
        <?php foreach ($news as $news_item): ?>
            <tr>
                <td>

                        <?php echo $news_item['id']; ?>

                </td>
                <td>
                    <a href="<?php echo $this->config->base_url().'index.php/news/'.$news_item['slug'] ?>">
                        <?php echo $news_item['title']; ?>
                    </a>
                </td>
                <td><?php echo $news_item['text']; ?></td>
                <td width="5%" align="right">
                    <div class="btn-group">
                        <a class="btn btn-info btn-xs" title="Edit"
                           href="<?php echo $this->config->base_url().'index.php/news/edit/'.$news_item['id'] ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a class="btn btn-info btn-xs delete_item" title="Delete"
                           href="<?php echo $this->config->base_url().'index.php/news/delete/'.$news_item['id'] ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="45">Nothing to show</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function(){

        $(document).on('click','.delete_item',function(e){

            e.preventDefault();

            var $elmnt=$(this);
            var $elmnt_row=$elmnt.parents('tr');

            var response=confirm("Do you really want to delete this record?");

            if(!response)return false;

            var url=$elmnt.attr('href');

            //loader
            $elmnt_row.css('opacity','0.5');

            $.get(url,function(data){

                if($.trim(data)=='Deleted')
                {
                    $elmnt_row.fadeOut(1000,function(){$(this).remove()});
                }
                else
                {
                    console.log(data);
                }
            })
            //loader if deletion failed.
            .fail(function(){
                $elmnt_row.css('opacity',1);
            });

        });
    });
</script>