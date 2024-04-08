<?php if ($imageFilePath !== null): ?>
            <div class="mb-3">
                <label for="formFile" class="form-label">Current Image</label>
                <div class="mb-3">
                    <img src="/img/uploads/<?php echo htmlspecialchars($imageFilePath); ?>" class="img-fluid img-thumbnail"
                        alt="Current Image">
                </div>
                <input class="form-control" type="file" id="formFile" name="newImage">
                <button type="submit" name="resetImage" value="1" class="btn btn-warning mt-2">Reset to Default
                    Image</button>
            </div>
        <?php endif; ?>