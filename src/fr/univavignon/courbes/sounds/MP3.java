package fr.univavignon.courbes.sounds;

import java.io.BufferedInputStream;
import java.io.FileInputStream;

import javazoom.jl.player.Player;

public class MP3 {
    private String filename;
    private Player player;

    // constructeur prend le nom du fichier son
    public MP3(String filename) {
        this.filename = filename;
    }

public String getFile(){
	return filename;
}

    public void close() { if (player != null) player.close(); }

    // demarrer le son
    public void play() {
        try {
            FileInputStream fis     = new FileInputStream(filename);
            BufferedInputStream bis = new BufferedInputStream(fis);
            player = new Player(bis);
           
        }
        catch (Exception e) {
            System.out.println("Problem playing file " + filename);
            System.out.println(e);
            String filename ="./res/sounds/Kalimba.mp3";
            MP3 m = new MP3(filename);
            m.play();
            
        }

        // run in new thread to play in background
        new Thread() {
            public void run() {
                try { player.play(); }
                catch (Exception e) { System.out.println(e); }
            }
        }.start();

    }
    
       /* stopper le son
        mp3.close();*/
      
}