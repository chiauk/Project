import speech_recognition as sr
r = sr.Recognizer()
sr.energy_threshold = 4000
with sr.Microphone() as source:
    audio = r.listen(source)

try:
    print("You said " + r.recognize_google(audio,language="zh_TW"))
except sr.UnknownValueError:
    print("Could not understand audio")