import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import PrimaryButton from "@/Components/PrimaryButton";
import { useForm } from "@inertiajs/react";
import Feature from "@/Components/Feature";

export default function Index({feature, answer}){
    const {data, setData, post, reset, errors, processing} = useForm({
        number1:"",
        number2:"",
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("feature1.calculate"), {
            onSuccess(){
                reset();

            },
        });
    };

    return(
        <Feature feature={feature} answer={answer}>
            <form onSubmit={submit}  className="p-8 grid grid-cols-2 gap-3"  action="">
                <div>
                    <InputLabel htmlFor="number1" value="Number 1"/>

                    <TextInput
                    id="number1"
                    type="text"
                    name="number1"
                    value={data.number1}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("number1", e.target.value)}
                    />

                    <inputError messag={errors.number1} className="mt-2" />
                </div>
                
                <div>
                    <InputLabel htmlFor="number2" value="Number 2"/>

                    <TextInput
                    id="number2"
                    type="text"
                    name="number2"
                    value={data.number2}
                    className="mt-1 block w-full"
                    onChange={(e) => setData("number2", e.target.value)}
                    />
 
                    <inputError messag={errors.number2} className="mt-2" />
                </div>

                <div className="flex items-center justify-end mt-4 col-span-2">
                    <PrimaryButton className="ms-4" disabled={processing}>
                        Calculate
                    </PrimaryButton>

                </div>
            </form>
        </Feature>
    )
}


// Code Part	What it does
// import { useForm }	Brings Inertia form helper for handling form state + POST requests
// export default function Feature1(...)	This file is a page, exported so Inertia can load it
// ({ user, credits })	These values come from the Laravel controller as props
// useForm({...})	Initializes form state (number1, number2) like $request->input() in Laravel
// handleSubmit()	Stops page reload and sends a POST request to Laravel
// post('/feature1/calculate')	Hits your Laravel controller route for processing
// <input ... setData()>	Updates state just like writing to $request->input()
// processing	Locks button while waiting for Laravel response
// errors.xxx	Shows validation errors from Laravel if form fails