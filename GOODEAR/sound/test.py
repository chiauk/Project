# -*- coding: utf8 -*-

import pyaudio
import speech_recognition as sr
from pygame import mixer
import os
import speekmodule

doss = os.getcwd()
i=0
n=0

# JARVIS'S EARS========================================================================================================== SENSITIVE BRAIN
                                                   # obtain audio
while (i<=1):

    r = sr.Recognizer()
    with sr.Microphone() as source:
        audio = r.adjust_for_ambient_noise(source)
        n=(n+1)     
        print("Say something!")
        audio = r.listen(source)
                                                   # interprete audio (Google Speech Recognition)
    try:
        #s = (r.recognize_google(audio,language="en"))
        s = 'hahahahahaha hello'
        message = (s.lower())
        print (message)
       

# POLITE JARVIS ============================================================================================================= BRAIN 1
            
        if ('hello') in message or ('hi') in message:
            rand = [u'謝謝']
            speekmodule.speek(rand,n,mixer)
            i=(i+1)
            print i

    # exceptions
    except sr.UnknownValueError:
        print(u"※Please say it again※")
    except sr.RequestError as e:
        print("Could not request results$; {0}".format(e))



