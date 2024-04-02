<div id="addPageModal"
    style="display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div
        style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0;">Add New Page</h5>
            <button type="button" id="closeModalBtn"
                style="border: none; background-color: transparent; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form action="/add-page" method="post">
            <div style="margin-top: 20px;">
                <label for="pageTitle">Page Title</label>
                <input type="text" id="pageTitle" name="pageTitle" required
                    style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="margin-top: 20px;">
                <label for="sectionAmount">Amount of Sections</label>
                <input type="number" id="sectionAmount" name="sectionAmount" min="1" max="10" required
                    style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
                <button type="button" id="closeModalFooterBtn"
                    style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; cursor: pointer; margin-right: 10px;">Close</button>
                <button type="submit"
                    style="padding: 8px 16px; background-color: #007bff; color: white; border: none; cursor: pointer;">Save
                    changes</button>
            </div>
        </form>
    </div>
</div>