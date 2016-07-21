"""
Creates a csv file containing all hypothetical users, threads, and messages
into three different files:
users.csv
threds.csv
messages.csv
@author Martin Suarez
"""

import hashlib
import random
from datetime import datetime, timedelta, date

# Website information
CREATION_DATE = datetime.strptime('2014-01-01 00:00:00', '%Y-%m-%d %H:%M:%S') # Hypothetical creation date
PASSWORD = "hello".encode('utf-8');  # Universal password for all users. Will still be SHA1 encrypted.

# File information
USERS_F    = "csv/users.csv"   
THREADS_F  = "csv/threads.csv"
MESSAGES_F = "csv/messages.csv"

# User information
M_NAMES=["Billy",  "Bob", "Joe",  "Frank",  "Aaron", "Andrew", "Andy", "Andres", "Buck", "Ben",
         "Bobby",  "Bara",  "Carl", "Chris", "Cecil", "Carter", "Cody", "Daniel", "Don",  "Dimitri",
         "Dennis",  "Derick", "Dan", "Efrain",  "Felix", "Fedor", "Guy", "Gendry", "Goliath", "Harry",
         "Hector", "Hunter", "Humberto", "Isaac", "Ivan", "Jacob", "Jora", "Ken", "Kent", "Lenny",
         "Martin",  "Nate",  "Oswin", "Owain",  "Quentin", "Randy", "Ray",  "Rick", "Rory", "Ron", "Simon",
         "Terry", "Tommy",  "Victor",]

F_NAMES=["Mandy", "Sue", "Erin", "Valencia", "Abby", "Allie", "Andrea", "Amber", "Alice", "Aurora",
         "Ana", "Berta", "Beatriz", "Bella", "Cindy", "Carol", "Cecilia", "Celia", "Dona", "Didi",
         "Erinn", "Ella", "Eyra", "Ellie", "Farah", "Gigi","Heidi", "Hillary", "Isadora", "Isabelle",
         "Jennifer", "Karla", "Kelly", "Kendra", "Lin", "Lua", "Mary", "Mirna", "Nana", "Natalie",
         "Nelly", "Oprah", "Reina", "Serra", "Selena", "Sansa", "Tina", "Usha",  "Vecky", "Zara"]

LAST_NAMES=["Smith", "Doe", "Miller", "Williams", "Anderson", "Thompson", "Wilson", "Anderson", "Andrews",
            "Bohr", "Camels", "Dennis", "Edwards", "Lewis", "Swift", "Burnstein", "Baker", "Green", "Black",
            "Tailor", "Tanner", "Vincenti", "Barnes", "Burlington", "Wade", "Franklin", "Thorpe", "Ludgate",
            "Evans", "Swanson", "Perkins", "Traeger", "Wyatt", "Steele", "Spencer", "White", "Gates" ]

EMAILS = ["yahoo.com", "gmail.com", "hotmail.com"]

# Thread Topics
T_QUESTION = ["How do I ", "Where do I ", "When can I ", "With who do I ", "How many times must I "]
T_VERB = ["defeat ", "find ", "obtain ", "revive ", "check ", "discover ", "plot against ", "betray "]
T_ARTICLE = ["the ", "some ", "many ", "all ", "some of the ", "many of the ", "all of the "]
T_SUBJECT = ["Demon Lords", "Holy Swords", "fruit", "magic", "magic beans", "imps", "goblins", "orcs", "demons", "dragons",
           "insects", "lizards", "elementals", "pidgeons", "zombies", "vampires"]

# Message Contents
M_SUBJECT = ["They really", "Seriously, try to", "Maybe you can", "Try to", "Mmm... oh I know,", "Give up, they"]
M_VERB = ["attack", "defend", "jump", "summon", "cast", "escape"]
M_ADJECTIVE = ["well", "bad", "fast", "slow", "forcefully"]
M_ARTICLE = ["with", "using", "on"]
M_ITEM = ["swords", "staffs", "knives", "spells", "magic", "items", "lances", "horses", "mounts", "luck"]


# Helper Functions
def random_datetime(start, end):
    """
    This function will return a random datetime between two datetime
    objects.
	Credit: nosklo at http://stackoverflow.com/questions/553303/generate-a-random-date-between-two-other-dates
    """
    delta = end - start
    int_delta = (delta.days * 24 * 60 * 60) + delta.seconds
    random_second = random.randrange(int_delta)
    return start + timedelta(seconds=random_second)

def random_date(start, end):
    """
    Returns a random date object between two dates.
    """
    delta = end - start
    random_days = random.randrange( delta.days )
    return (start + timedelta(days=random_days)).date()

# File creation functions
def create_users (num_users):
    """
    Creates random users in the "user" table of the "forum" database.
    Parameters:
         num_users = the amount of users to be created.
    """
    out = open(USERS_F, "w");
    out.write( "username, password, first_name, last_name, email, registration_date, dob, gender\n" )
    for i in range(num_users):
        # 50/50 chance of gender
        if (random.randint(0, 1) == 0):
            first_name = F_NAMES[random.randint(0, len(F_NAMES)-1)]
            gender = "Female"
        else:
            first_name = M_NAMES[random.randint(0, len(M_NAMES)-1)]
            gender = "Male"
        last_name = LAST_NAMES[random.randint(0, len(LAST_NAMES)-1)]
        username = first_name.lower() + str(i)
        email = username + "@" + EMAILS[random.randint(0, len(EMAILS)-1)]
        registration_date = random_datetime(CREATION_DATE, datetime.now())
        dob = random_date(datetime.strptime("1940", "%Y"), datetime.strptime("2003", "%Y"))
        line = "%s~%s~%s~%s~%s~%s~%s~%s\n" % (username, hashlib.sha1(PASSWORD).hexdigest(), first_name, last_name, email, registration_date, dob, gender)
        out.write(line)
    out.close()

def create_threads (num_users, num_forums, num_threads, max_messages_per_forum=15):
    """
    Creates the specified number of random threads with some random content.

     Parameters:
         num_users = the amount of users in the database
         num_forums = the amount of forums in the database
         num_threads = the amount of threads to be created.
         max_messages_per_forum = default 15, must be higher than 5
    """
    # Create threads
    out_t = open(THREADS_F, "w")
    out_t.write( "forum_id, user_id, title, date_created\n" )
    out_m = open(MESSAGES_F, "w")
    out_m.write( "thread_id, user_id, message, date_posted\n" )
    for i in range(num_threads):
        forum_id = random.randint(1, num_forums)
        author = random.randint(1, num_users)  # aka user_id
        title = T_QUESTION[random.randint(0, len(T_QUESTION)-1)] + T_VERB[random.randint(0, len(T_VERB)-1)] + \
                T_ARTICLE[random.randint(0, len(T_ARTICLE)-1)] + T_SUBJECT[random.randint(0, len(T_SUBJECT)-1)] + "?";
        date_created = random_datetime(CREATION_DATE, datetime.now())
        line = "%d~%d~%s~%s\n" % (forum_id, author, title, date_created)
        out_t.write(line)
        # For each thread created, create a random number of messages between 5 and max_messages_per_forum
        date_posted = date_created
        # Add 3 participants to the thread
        posters = [random.randint(1, num_users), random.randint(1, num_users), random.randint(1, num_users)] 
        for j in range(random.randint(5, max_messages_per_forum) ):
            # One in four posts will be the author, the other three the participants
            poster = random.randint(1, 4)
            # If first message, the author is the first poster
            if j == 0:
                poster = author
            elif poster == 4:
                poster = author
            else:
                poster = posters[poster-1]
            message = M_SUBJECT[random.randint(0, len(M_SUBJECT)-1)] + " " + M_VERB[random.randint(0, len(M_VERB)-1)] +  " " + \
                      M_ADJECTIVE[random.randint(0, len(M_ADJECTIVE)-1)] + " " + M_ARTICLE[random.randint(0, len(M_ARTICLE)-1)] + " " + \
                      M_ITEM[random.randint(0, len(M_ITEM)-1)] + "."
            line = "%d~%d~%s~%s\n" % (i, poster, message, date_posted)
            out_m.write(line)
            # Put some time between posts
            date_posted = date_posted + timedelta(seconds=random.randint(60, 1000))
    out_m.close()
    out_t.close()


def main():
    create_users(500)
    create_threads(500, 7, 1400, 60)
    
main()
