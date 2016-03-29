package fr.univavignon.courbes.sounds;
import javax.sound.sampled.Clip;

import fr.univavignon.courbes.Launcher;
import fr.univavignon.courbes.inter.simpleimpl.AbstractRoundPanel;

import java.io.BufferedInputStream;

public class Soundloop implements Runnable{

	@Override
	public void run(){
		while (true){
		//	AbstractRoundPanel.music.getClip().loop(Clip.LOOP_CONTINUOUSLY);
				try {
				Thread.sleep(1000);
			
		        }
		        catch(Exception e){
					e.printStackTrace();
				}
		
			}	
		}
	}

