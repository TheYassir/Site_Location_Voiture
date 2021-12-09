
    <header class="py-5 position-relative" style="width:100%; height:800px; background-image: url('assets/background.jpg'); background-size: cover; background-repeat: no-repeat">
            <div class="text-center my-5">
                <h1 class="text-white fs-3 fw-bolder">Bienvenue à bord</h1>
                <p class="text-white-50 mb-0">Location de voiture 24h/24 et 7j/7</p>
            </div>
            <div class="position-absolute start-50 translate-middle mx-auto disp">
                <form method="post" class="d-flex mx-auto">
                    <div class="p-3 mia">
                        <p class="pb-1">Adresse&nbsp;de&nbsp;départ</p>
                        <select  class="form-select my-auto" name="ville" id="ville">
                        <option value="Paris">Paris</option>
                        <option value="Lyon">Lyon</option>
                        <option value="Marseille">Marseille</option>
                        <option value="Nice">Nice</option>
                        <option value="Lille">Lille</option>
                        </select>
                    </div>
                    <div class="p-3 mia">
                        <p class="pb-1">Début de location</p>
                        <input type="date" class="form-control" id="date_heure_depart" name="date_heure_depart">
                    </div>
                    <div class="p-3 mia">
                        <p class="pb-1">Fin de location</p>
                        <input type="date" class="form-control" id="date_heure_fin" name="date_heure_fin">
                    </div>
                    <div class="mia2">
                        <button type="submit" class="btn mia2 py-5 text-white">Valider&nbsp;un&nbsp;véhicule</button>
                    </div>

                </form>
            </div>
        </header>     
