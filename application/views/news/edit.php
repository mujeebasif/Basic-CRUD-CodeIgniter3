
<?php
$errors = validation_errors();
if( !empty($errors) )
{
    echo '<div class="alert alert-warning">';
        echo $errors;
    echo '</div>';
}
?>

<div class="page-header">
    <h1 class="text-info"><?php echo $title ?></h1>
</div>


<?php echo form_open('news/edit') ?>

<div class="form-group">
    <label for="title">Title</label>
    <input type="input" name="title" class="form-control" value="<?php if(!empty($news_item['title']))echo $news_item['title']; ?>" />
</div>

<div class="form-group">
    <label for="text">Text</label>
    <textarea name="text" class="form-control"><?php if(!empty($news_item['text']))echo $news_item['text']; ?></textarea>
</div>

<input type="submit" name="submit" class="btn btn-info" value="Save" />
<a class="btn btn-default" href="<?php echo $this->config->base_url()?>index.php/news">Cancel</a>

<input type="hidden" name="id" value="<?php if(!empty($news_item['id']))echo $news_item['id']; ?>" >

</form>