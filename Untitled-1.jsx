import setting from 'setting';

const data = {
    a : {
        foo : 1 ,
        bar : 2
    } ,
    b : {
        foo : 3 ,
        bar : 4
    }
}

//DEFINE GETTER
//something like this
data.DEFINE_GETTER(function(property)
{
    if(setting.type === 'a')
        return data['a'][property];
    else
        return data['b'][property];
})

export default data;


//----------


import data from 'data';
import setting from 'setting';

setting.type = 'a';
console.log(data.foo)   //should be 1


