    <?php
    $heroConfigPath = "../assets/data/heroConfig.json";
    $heroImages = file_exists($heroConfigPath) ? json_decode(file_get_contents($heroConfigPath), true) : [];
    ?>

    <?php include "header.php"; ?>

    <div class="container py-4">
        <h2>Manage Hero Banners</h2>
        <div id="heroBannerList" class="row g-3">
            <?php foreach ($heroImages as $index => $hero): ?>
                <div class="col-md-6 col-lg-3 position-relative banner-item">
                    <?php if (!empty($hero['link']) && $hero['link'] !== "#"): ?>
                        <a href="<?= htmlspecialchars($hero['link']) ?>">
                            <img src="../<?= htmlspecialchars($hero['image']) ?>" class="img-fluid w-100 rounded shadow-sm">
                        </a>
                    <?php else: ?>
                        <img src="../<?= htmlspecialchars($hero['image']) ?>" class="img-fluid w-100 rounded shadow-sm">
                    <?php endif; ?>
                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-btn" 
                            data-filename="<?= htmlspecialchars($hero['image']) ?>" 
                            data-bs-toggle="modal" data-bs-target="#deleteBannerModal" 
                            data-index="<?= $index ?>">
                        &times;
                    </button>
                </div>
            <?php endforeach; ?>
            
            <!-- Add new image button -->
            <div class="col-md-6 col-lg-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center" 
                        data-bs-toggle="modal" data-bs-target="#addBannerModal">
                    <i class="fas fa-plus"></i> Add Banner
                </button>
            </div>
        </div>
    </div>

    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Banner Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadBannerForm">
                        <input type="file" id="bannerFile" class="form-control mb-3" accept="image/*" required>
                        <input type="text" id="bannerLink" class="form-control mb-3" placeholder="Enter sectionDiv ID or #">
                        <button type="submit" class="btn btn-primary w-100">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteBannerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this banner?</p>
                    <input type="hidden" id="deleteBannerFilename">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBanner">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Upload Banner
        document.getElementById("uploadBannerForm").addEventListener("submit", function (e) {
            e.preventDefault();
            let fileInput = document.getElementById("bannerFile");
            let linkInput = document.getElementById("bannerLink").value.trim() || "#";
            let file = fileInput.files[0];

            if (file && file.type.startsWith("image/")) {
                let formData = new FormData();
                formData.append("bannerImage", file);
                formData.append("link", linkInput);

                fetch("phpScripts/uploadBanner.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text()) 
                .then(text => {
                    try {
                        let data = JSON.parse(text);
                        if (data.success) {
                            location.reload();
                        } else {
                            alert("Upload failed: " + data.error);
                        }
                    } catch (error) {
                        alert("Invalid server response: " + text);
                    }
                })
                .catch(err => alert("Error: " + err.message));
            } else {
                alert("Please select a valid image file.");
            }
        });

        // Handle Delete Button Click (Set Data for Modal)
        document.querySelectorAll(".delete-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                let filename = this.getAttribute("data-filename");
                document.getElementById("deleteBannerFilename").value = filename;
            });
        });

        // Confirm Deletion
        document.getElementById("confirmDeleteBanner").addEventListener("click", function () {
            let filename = document.getElementById("deleteBannerFilename").value;

            fetch("phpScripts/deleteBanner.php", {
                method: "POST",
                body: JSON.stringify({ filename }),
                headers: { "Content-Type": "application/json" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Delete failed: " + data.error);
                }
            })
            .catch(err => alert("Error: " + err.message));
        });
    });
    </script>

    <?php include "footer.php"; ?>
