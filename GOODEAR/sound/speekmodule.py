from gtts import gTTS
import random
import os

def speek(rand,n,mixer):
    tts = gTTS(text=random.choice(rand), lang='zh')                 
    tts.save('C:\Users\CHIAU\Desktop\GoodEar\sound\o1_'+str(n)+'.mp3')
    #tts.save('/var/www/html/jarvis'+str(n)+'.mp3')

