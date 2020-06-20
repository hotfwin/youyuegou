
<?= \Config\Services::validation()->listErrors(); ?>

<?= form_open(); ?>
<label for="title">Title</label>
<input type="input" name="title" value="<?= old('title') ?>" ><br>

<label for="body">Text</label>
<textarea name="body"></textarea> <br>

<input type="submit" name="submit" value="提交">
</form>
