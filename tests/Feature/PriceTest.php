<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PriceTest extends TestCase
{
    use RefreshDatabase;
   

    public function test_user_can_store_price(): void
    {
        $data=['prices'=>
            [['price'=>30.00,
            'name'=>'Fish'
        ],
        ['price'=>20.00,
            'name'=>'cuccumber'
            ]]
        ];
        $this->seed();

        $user = User::has('specialist')->first();
        $prices=$user->specialist->prices()->get();
        foreach($prices as $price)
        {
            $price->delete();
        }
   
  
        $response = $this->actingAs($user)->fromRoute('specialist.profile.edit',$user->specialist->id)->post(route('specialist.price.store',$user->specialist->id),$data['prices'][0]); 
      
        $response->assertRedirectToRoute('specialist.profile.edit',$user->specialist->id);
        
        $models=$user->specialist->prices()->get();
        $this->assertEquals(1,count($models));
        $this->assertSame($models[0]->name,$data['prices'][0]['name']);
        $this->assertSame($models[0]->price,$data['prices'][0]['price']);
    }
    public function test_user_can_delete_price(): void
    {
        $data=['prices'=>
            [['price'=>30.00,
            'name'=>'Fish'
        ],
        ['price'=>20.00,
            'name'=>'cuccumber'
            ]]
        ];
        $this->seed();

        $user = User::has('specialist')->first();
        $prices=$user->specialist->prices()->get();
        foreach($prices as $price)
        {
            $price->delete();
        }
        foreach($data['prices'] as $price)
        {
            $user->specialist->prices()->create($price);
        }
        $prices=$user->specialist->prices()->get();
        $fish=$prices->where('name','Fish')->firstOrFail();
        $cuccumber=$prices->where('name','cuccumber')->firstOrFail();
        $response = $this->actingAs($user)->fromRoute('specialist.profile.edit',$user->specialist->id)->delete(route('specialist.price.delete',[$user->specialist->id,$fish->id]),$data); 
      
        $response->assertRedirectToRoute('specialist.profile.edit',$user->specialist->id);
        
        $this->assertEquals(1,count($user->specialist->prices()->get()));
        $this->assertModelExists($cuccumber);
        $this->assertModelMissing($fish);
    }

    public function test_user_cant_delete_other_user_price(): void
    {
        $data=['prices'=>
            [['price'=>30.00,
            'name'=>'Fish'
        ],
        ['price'=>20.00,
            'name'=>'cuccumber'
            ]]
        ];
        $this->seed();

        $user = User::has('specialist')->first();
        $fraud=User::has('specialist')->where('id','!=',$user->id)->first();
        $prices=$user->specialist->prices()->get();
        foreach($prices as $price)
        {
            $price->delete();
        }
        foreach($data['prices'] as $price)
        {
            $user->specialist->prices()->create($price);
        }
        $prices=$user->specialist->prices()->get();
        $fish=$prices->where('name','Fish')->firstOrFail();
        $cuccumber=$prices->where('name','cuccumber')->firstOrFail();
        $response = $this->actingAs($fraud)->fromRoute('specialist.profile.edit',$user->specialist->id)->delete(route('specialist.price.delete',[$user->specialist->id,$fish->id])); 
      
        $response->assertRedirectToRoute('specialist.profile.edit',$user->specialist->id);
        
        $this->assertEquals(2,count($user->specialist->prices()->get()));
        $this->assertModelExists($cuccumber);
        $this->assertModelExists($fish);
    }

    public function test_user_can_update_price(): void
    {
        $data=['prices'=>
            [['price'=>30.00,
            'name'=>'Fish'
        ],
        ['price'=>20.00,
            'name'=>'cuccumber'
            ]]
        ];
        $this->seed();

        $user = User::has('specialist')->first();
        $price=$user->specialist->prices()->create($data['prices'][0]);
    

        $response = $this->actingAs($user)->fromRoute('specialist.profile.edit',$user->specialist->id)->put(route('specialist.price.update',[$user->specialist->id,$price->id]),$data['prices'][1]); 
    
        $response->assertRedirectToRoute('specialist.profile.edit',$user->specialist->id);
        
        
        $price->refresh();
        $this->assertModelExists($price);
        $this->assertSame($price->name, $data['prices'][1]['name']);
        $this->assertSame($price->price, $data['prices'][1]['price']);
        

    }

}
