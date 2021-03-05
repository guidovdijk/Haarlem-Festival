<?php
include '../classes/autoloader.php';

$head = new head("CMS - Dashboard", "page--cms");
$head->render();

$artistController = new artistController();
$locationController = new locationController();
$location = $locationController->getDanceLocations();
if(isset($_POST['submit']))    
{
    $artistController->addPerformance();
}

$navigation = new cmsNavigation("Events");
$navigation->render();
?>

    <div class="cms-container row">
        <nav class="breadcrumbs breadcrumbs--cms col-12">
            <ul>
                <li class="breadcrumbs__breadcrumb"><a href="edit-pages.php">Events</a></li>
                <li class="breadcrumbs__breadcrumb"><a href="#">The Family XL</a></li>
            </ul>
        </nav>
       
        <article class="card--cms col-8">
            <header class="card--cms__header">
                <h3 class="card--cms__header__title">Event Details</h3>
            </header>
            <form class="card--cms__body row">
                <p class="card--cms__body__form-title col-12">Artist</p>

                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Band</label>
                    <select name="artist" id="artist">
                        <option selected value="Family XL">Family XL</option>
                    </select>
                </fieldset>

                <p class="card--cms__body__form-title col-12">Date and time</p>
                
                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Date</label>
                    <select name="Date" id="Date" class="has-placeholder">
                        <option value="" disabled selected hidden>Date...</option>
                        <option value="21-3-2020">21-03-2020</option>
                    </select>
                </fieldset>

                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Start time</label>
                    <input type="time" name="start_time" id="start_time">
                </fieldset>

                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Duration (in hours)</label>
                    <input type="number" name="duration" id="duration">
                </fieldset>

                <p class="card--cms__body__form-title col-12">Location and tickets</p>
                
                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Location</label>

                    <select name="location" id="location" class="has-placeholder">
                        <option value="" disabled selected hidden>Location...</option>
                        <?php
                        foreach ($location as $l) {
                            echo "<option value=" . $l->mutateToArray()['id'] . ">" . $l->mutateToArray()['name'] . "</option>";
                        }
                        ?> 
                        <option value="patronaat">Patronaat</option>
                    </select>
                </fieldset>

                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Seats*</label>
                    <input disabled value="200" type="number" name="seats" id="seats">
                </fieldset>

                <fieldset class="col-6 col--children-fullwidth">
                    <label class="label">Price per ticket (in euro's)*</label>
                    <input disabled value="12.50" type="number" name="price" id="price">
                </fieldset>

                <p class="card--cms__body__additional">*You do not have the rights to change the Seats and Price Per Ticket.</p>

                <div class="col-12 row justify-content-end">
                    <input class="button" type="submit" name="submit" value="Create new performance">
                </div>
            </form>
        </article>
 
    </div>
    
<?php 
    $footer = new footer();
    $footer->renderEndTag();
?>