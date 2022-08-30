Amplitude.init({
    "songs": [
        {
            "name": "Le bal masqué",
            "artist": "Opium du peuple",
            "album": "La révolte des opiumettes",
            "url": "./song/le-bal-masque.mp3",
        },
        {
            "name": "Poupée de cire, poupée de son",
            "artist": "Opium du peuple",
            "album": "La révolte des opiumettes",
            "url": "./song/poupee-de-cire.mp3",
        }
    ],
    callbacks: {
        //pour démarrer la lecture à cuaque fois que l'on passe au morceau suivant ou préc
        song_change: function () {
            Amplitude.play();
        }
    }
});