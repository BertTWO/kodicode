<?php
$firstname = $data[0]['firstname'] ?? $_SESSION['user']['username'];
$lastname = $data[0]['lastname'] ?? '';
$bio = $data[0]['bio'] ?? 'This is a bio';
$address = $data[0]['address'] ?? '';
$contact_no = $data[0]['contact_no'] ?? '';
$email = $_SESSION['user']['email'];
$dataImage = ($data[0]['profile_picture'] ?? '/uploads/noProfile.png');

?>

<form action="profile" method="post" enctype="multipart/form-data">

    <div class="row g-4">
        <!-- Profile Image Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center d-flex flex-column">
                    <div class="position-relative mx-auto mb-3">
                        <img src="<?php echo $dataImage; ?>"
                            id="profileImage"
                            class="rounded-circle mb-3 border border-4 border-white"
                            width="150"
                            height="150"
                            style="object-fit: cover; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <label for="imageUpload" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-pill shadow-sm">
                            <i class="bi bi-camera-fill me-1"></i>
                            <span class="d-none d-sm-inline">Change</span>
                            <input type="file"
                                id="imageUpload"
                                name="profile_image"
                                hidden
                                accept="image/png, image/jpeg">
                        </label>
                    </div>


                    <h4 class="mb-1"><?php echo htmlspecialchars($firstname . ' ' . $lastname); ?></h4>
                    <p class="text-muted mb-4"><?php echo htmlspecialchars($email); ?></p>

                    <div class="mt-auto">
                        <button type="submit" class="btn btn-success w-100 rounded-pill">
                            <i class="bi bi-save-fill me-2"></i>Save Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header mb-5 bg-light">

                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control border" name="firstName"
                                    value="<?php echo htmlspecialchars($firstname); ?>" placeholder="First Name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" name="lastName"
                                    value="<?php echo htmlspecialchars($lastname); ?>" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" class="form-control" name="address"
                                    value="<?php echo htmlspecialchars($address); ?>" placeholder="Your address">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" class="form-control" name="contact"
                                    value="<?php echo htmlspecialchars($contact_no); ?>" placeholder="Phone number">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" name="bio" rows="4"
                                placeholder="Tell us about yourself"><?php echo htmlspecialchars($bio); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        const imageUpload = document.getElementById('imageUpload');
        const profileImage = document.getElementById('profileImage');

        if (imageUpload && profileImage) {
            imageUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                 
                    const imageUrl = URL.createObjectURL(file);
                    profileImage.src = imageUrl;

                    profileImage.onload = function() {
                        URL.revokeObjectURL(imageUrl);
                    };
                }
            });
        } else {
            console.error('Could not find required elements for image upload');
        }
    });
</script>