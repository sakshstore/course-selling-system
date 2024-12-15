public function test()
    {
        $user = User::where('email', "susheel3010@gmail.com")->first();

        Auth::loginUsingId($user->id);
        event(new UserLoggedIn($user));
        event(new AdminLoggedIn($user));

        return 1;

        Mail::raw('Thisqmail', function ($message) {
            $message->to('test@example.com')
                ->subject('Tqqqil');
        });

        return 1;

        $d = array();

        $students = Student::with('tags')->get();

        foreach ($students as $student) {

            $d[] = $student->tags->pluck('id')->toArray();

        }

        $s = $d[0];

        $recipients = Student::whereHas('tags', function ($query) use ($s) {

            $query->whereIn('tags.id', $s);

        })->get();

        // Debugging: Print out the recipients
        // dd($recipients);

        return $recipients;

        event(new UserLoggedIn(Auth::user()));

        return Auth::user();
 
$user = User::where('email',  "susheel3010@gmail.com")->first();

$user->assignRole('guide');

$user->save();
//   Role::create(['name' => 'student']);
// Role::create(['name' => 'auth']);
//Role::create(['name' => 'guide']);

 

    }