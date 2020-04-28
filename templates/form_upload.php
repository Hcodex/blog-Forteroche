<form  method="post" action="../public/index.php?route=upload" enctype="multipart/form-data">
        <div class="custom-file my-2">
            <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" required>
            <label class="custom-file-label" for="fileToUpload" data-browse="Parcourir">Image à uploader</label>
            
        </div>
        <input type="submit" class="btn btn-primary my-2" value="Envoyer" id="submit" name="submit">
</form>