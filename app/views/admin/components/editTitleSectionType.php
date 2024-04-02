<div class="mb-3 d-flex justify-content-between align-items-end">
    <div class="flex-grow-1 me-3">
        <label for="sectionTitle" class="form-label">Section Title</label>
        <input type="text" class="form-control" id="sectionTitle" name="sectionTitle"
            value="<?php echo htmlspecialchars($sectionTitle); ?>" required>
    </div>

    <div>
        <label for="sectionType" class="form-label">Section Type</label>
        <select name="newType" id="sectionType" class="form-select" <?php echo in_array($pageIDFromSection, [PAGE_ID_HOME, PAGE_ID_HISTORY, PAGE_ID_DANCE, PAGE_ID_JAZZ, PAGE_ID_YUMMY]) ? 'disabled' : ''; ?>>
            <option value="Banner" <?php echo ($sectionType === 'Banner') ? 'selected' : ''; ?>>Banner</option>
            <option value="Body" <?php echo ($sectionType === 'Body') ? 'selected' : ''; ?>>Body</option>
            <option value="Title" <?php echo ($sectionType === 'Title') ? 'selected' : ''; ?>>Title</option>
            <option value="Image" <?php echo ($sectionType === 'Image') ? 'selected' : ''; ?>>Image</option>
            <option value="ImageText" <?php echo ($sectionType === 'ImageText') ? 'selected' : ''; ?>>Image & Text
            </option>
        </select>
    </div>
</div>