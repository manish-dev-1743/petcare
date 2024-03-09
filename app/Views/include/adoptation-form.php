<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="adopt-pet">
      <div class="modal-body">
        <h3 class="text-center">Personal Information</h3>
        <hr>
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" class="form-control" id="fullname" required>
        </div>
        <div class="form-group">
            <label for="number">Number</label>
            <input type="text" name="number" class="form-control" id="number" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address</label>
            <input type="text" name="home_address" class="form-control" id="home_address" required>
        </div>
        <hr>
        <h3 class="text-center">Living Arrangemets</h3>
        <hr>
        <div class="form-group">
            <h6>Do you own or rent your home?</h6>
            <input type="radio" id="own" name="ownorRent" value="own" required>
            <label for="own" style="margin-right: 60px;">Own</label>
            <input type="radio" id="rent" name="ownorRent" value="rent" required>
            <label for="rent">Rent</label>
        </div>
        <div class="form-group">
            <h6>If renting, do you have permission from your landlord to have a pet?</h6>
            <input type="radio" id="yes" name="landlordPermission" value="yes" required>
            <label for="yes" style="margin-right: 30px;">Yes</label>
            <input type="radio" id="no" name="landlordPermission" value="no" required>
            <label for="no" style="margin-right: 30px;">No</label>
            <input type="radio" id="na" name="landlordPermission" value="na" required>
            <label for="na">Not Applicable</label>
        </div>
        <hr>
                <h3 class="text-center">Previous Pet Experience</h3>
        </hr>
        <div class="form-group">
            <label for="ownedPetsBefore">Have you owned pets before?</label>
            <input class="form-control" type="text" id="ownedPetsBefore" name="ownedPetsBefore" placeholder="Yes/No" required>
        </div>
        <div class="form-group">
        <label for="experienceDescription">Experience Description:</label>
            <textarea class="form-control" id="experienceDescription" name="experienceDescription" rows="4" placeholder="Briefly describe your previous pet experience" required></textarea>
        </div>
        <div class="form-group">
            <h2>Additional Information</h2>
            <label for="adoptionReason">Why do you want to adopt a pet?</label>
            <textarea class="form-control" id="adoptionReason" name="adoptionReason" rows="4" placeholder="Explain your reason for adopting a pet" required></textarea>
        </div>
        <div class="form-group">
            <label for="openToSpecialNeeds">Are you open to adopting a pet with special needs?</label>
            <input class="form-control" type="text" id="openToSpecialNeeds" name="openToSpecialNeeds" placeholder="Yes/No" required>

        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Apply</button>
      </div>
      </form>
    </div>
  </div>
</div>
