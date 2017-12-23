# -*- coding: utf8 -*-

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import pyaudio
import speech_recognition as sr
from pygame import mixer
import os
import random
import webbrowser
import glob
from time import localtime, strftime
import speekmodule

doss = os.getcwd()
i=0
n=0

INFO = '''
        +--------------------------------------------+
        |........CHARLIE VIRTUAL INTELLIGENCE........|
        +============================================+
        |                  OPTIONS:                  |
        |#goodbye        #hello         #thanks      |
        |#charlie        #how are you   #*           |
        |#your name      #.com          #music       |
        |#youtube        #search        #google maps |
        |#1(sleep mode)  #music         #what time   |
        +============================================+
        '''
print(INFO)
# JARVIS'S EARS========================================================================================================== SENSITIVE BRAIN
                                                   # obtain audio
while (i<1):
    r = sr.Recognizer()
    with sr.Microphone() as source:
        audio = r.adjust_for_ambient_noise(source)
        n=(n+1)     
        print("Say something!")
        audio = r.listen(source)
                                                   # interprete audio (Google Speech Recognition)
    try:
        s = (r.recognize_google(audio,language="en"))
        message = (s.lower())
        print (message)


# POLITE JARVIS ============================================================================================================= BRAIN 1
    
        if ('goodbye') in message:                          
            rand = ['Goodbye Sir']
            speekmodule.speek(rand,n,mixer)
            break
            
        if ('hello') in message or ('hi') in message:
            rand = ['Wellcome to Charlie virtual intelligence project, sir.']
            speekmodule.speek(rand,n,mixer)

        if ('thanks') in message or ('tanks') in message or ('thank you') in message:
            rand = ['You are wellcome', 'no problem']
            speekmodule.speek(rand,n,mixer)

        if message == ('charlie'):
            rand = ['Yes Sir?', 'What can I doo for you sir?']
            speekmodule.speek(rand,n,mixer)

        if  ('how are you') in message or ('and you') in message or ('are you okay') in message:
            rand = ['Fine thank you']
            speekmodule.speek(rand,n,mixer)

        if  ('*') in message:
            rand = ['Be polite please']
            speekmodule.speek(rand,n,mixer)

        if ('your name') in message:
            rand = ['My name is CHARLIE, at your service sir']
            speekmodule.speek(rand,n,mixer)

# USEFUL JARVIS ============================================================================================================= BRAIN 2


        if ('.com') in message :
            rand = ['Opening' + message]         
            Chrome = ("C:/Program Files (x86)/Google/Chrome/Application/chrome.exe %s")
            speekmodule.speek(rand,n,mixer)
            webbrowser.get(Chrome).open('http://www.'+message)

        if ('youtube') in message :
            driver = webdriver.Firefox()
            driver.get('http://youtube.com.tw')
            driver.find_element_by_id("masthead-search-term").clear()
            driver.find_element_by_id("masthead-search-term").send_keys(u"山海")
            driver.find_element_by_id("search-btn").click()    

        if ('search') in message :
            query = message
            stopwords = ['search']
            querywords = query.split()                                                      #把所講的話分割成一個個字串
            resultwords  = [word for word in querywords if word.lower() not in stopwords]   #過濾需求，resultwords = queryword沒有stop word的字串
            result = ' '.join(resultwords)                                                  #用' '把字串串聯起來
            Chrome = ("C:/Program Files (x86)/Google/Chrome/Application/chrome.exe %s")
            webbrowser.get(Chrome).open("https://www.google.com.tw/#q="+result)

        if ('google maps') in message:
            query = message
            stopwords = ['google', 'maps']
            querywords = query.split()
            resultwords  = [word for word in querywords if word.lower() not in stopwords]
            result = ' '.join(resultwords)
            Chrome = ("C:/Program Files (x86)/Google/Chrome/Application/chrome.exe %s")
            webbrowser.get(Chrome).open("https://www.google.com.tw/maps/place/"+result)
            rand = [result+'on google maps']
            speekmodule.speek(rand,n,mixer)

        if ('1') in message:
            rand = ['Screen lock']
            speekmodule.speek(rand,n,mixer)
            os.system('Rundll32.exe user32.dll LockWorkStation')

        if ('music') in message:
            mus = random.choice(glob.glob(doss + "\\music" + "\\*.mp3"))
            os.system('chown -R user-id:group-id mus')
            os.system('start ' + mus)
            rand = ['start playing']
            speekmodule.speek(rand,n,mixer)

        if ('what time') in message:
            tim = strftime("%X", localtime())
            rand = [tim]
            speekmodule.speek(rand,n,mixer)
            print rand
            
    # exceptions
    except sr.UnknownValueError:
        print(u"※Please say it again※")
    except sr.RequestError as e:
        print("Could not request results$; {0}".format(e))
