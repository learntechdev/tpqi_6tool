<textarea id="<?= $id ?>" name="<?= $id ?>"><?= $data ?></textarea>
<script type="text/javascript">
CKEDITOR.replace('<?= $id ?>', {
    fullPage: false, // ถ้ากำหนดเป็น false จะลบแท็ก HEAD/BODY/HTML ออกไม่ต้องเก็บลง db
    allowedContent: true,
    autoGrow_onStartup: true,
    enterMode: CKEDITOR.ENTER_BR,
    extraPlugins: 'wysiwygarea'
});
</script>