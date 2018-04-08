# laravelAccountCreationWithEmailVerification

## About this

This is a resume about different things (it's for my reference, and you may find it useful), around the implementation of a users registration with email confirmation (laravel examples, and different way of doing, and a resume of some good practice), and more then that about creating your own mail server, using some of the great open source projects. And resuming the concerns of having your own mailing server vs using a  cloud service. Also how to send using smtp, and others protocols. so it's about user registration and email servers.  [note, i will be updating that through time passing. (i'm not putting all at once)]


## First: User registration with email confirmation in laravel. Using events and a listner

You find an implementation in the folder **accountEmailConfirmation**

It's a direct follow of this online artical tutorial  [https://phpbits.in/email-verification-with-laravel-5-5/][https://phpbits.in/email-verification-with-laravel-5-5/]

Note bellow you will find a resume, and some outlines, and important notes.
Now that there is more then what in the tutorial, and it can be interesting. i will highlight in bold the very interesting or maybe important things.

### Here is a resume : 
We will be using the laravel default auth scaffolding (but follwing the same logic we can use others libraries for that. as laravel-permission by spatie for example).

#### The principal is as follow :
first we will add to the **users** table (and so the schema) a new field which is **'verified'**
we create another table **verification_tokens** (it will have a direct one to one relation with the users table) [each user will have his unique token]
(after setting the migration, and the env config and the database, we can launch the migrate to create the tables)

**controllers**
We add a controller for verification (VerificationController) wich contain a method **verify** (set user to verified) and another to resend the email (**resend**).

And we have to overide the methode of the auth registration and login controllers, (**registered** for registration and **authenticated** for login). What we do, is to logout and show the relevant messages and redirect. [after registration we redirect to login page and we show verify your email message. or if wanted we login the user. and we show the message too. not part of the tuto, we can then limit his access. Through checking his status (using conditions in the views. or using a role managment library as laravel-permission for example, and then we will set a role for that state, and associate it to him, and so he will be limited in access)]

For the verification controller, in resend email, we trigger an event for email resend which we would have created, and we have a listener that handle that. we are seeing that next.

**events and there listeners**
There is different ways of implementing that. We will see too another way which is not part of that tuto. but the way in this one and through using the events and the listeners,give a nice way that is flexible. Events let us easily organize the workflow, and the systematic between the different elements. 

Here how it's done, and it's stright forward. we set two events, one is user registred event. The other is  user email resend request event.  Then we have a listener that listen to both of those event. whenever one is triggered, we send the confirmation email to the user.  [know that the event we emit them, ourselve, in the right place. And in our example here: we emit the use registred event, on the registred methode overiding in the registration Auth controller. ]

**services providers**

**env configuration**
====> **smtp config when using google**

==> **we can use other things see the outline bellow [mail servers and configurtation and  some different options]**

### Here some of the important outline, and things you may find useful, and may be some trouble shooting, or things you may avoid:


// now this work is in progress! depending in my time.
