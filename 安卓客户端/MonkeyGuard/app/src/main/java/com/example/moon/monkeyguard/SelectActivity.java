package com.example.moon.monkeyguard;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;

import com.facepp.error.FaceppParseException;
import com.facepp.http.HttpRequests;
import com.facepp.http.PostParameters;

import org.apache.http.HttpRequest;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

/**
 * Created by moon on 2016/10/13.
 */
public class SelectActivity extends AppCompatActivity{
    ImageView image1 = null;
    ImageView image2 = null;
    ImageView image3 = null;
    EditText editText = null;
    Button button = null;

    String imgUrl = null;
    HttpRequests httpRequests = null;
    JSONObject result1 = null;
    JSONObject result2 = null;
    String [] url = new String [3];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select);

        httpRequests = new HttpRequests("c99a07af30ed83c07757b9bec46e8b8b", "K8F1T3lzc8WLW5NEJS-wWCz6mJ7PN5Rw", true, true);

        Intent intent = getIntent();
        imgUrl = intent.getStringExtra("imgUrl");

        image1 = (ImageView)findViewById(R.id.image1);
        image2 = (ImageView)findViewById(R.id.image2);
        image3 = (ImageView)findViewById(R.id.image3);
        editText = (EditText)findViewById(R.id.edit);
        button = (Button)findViewById(R.id.ok);

        three();

        new DownImgAsyncTask(image1).execute(url[0]);
        new DownImgAsyncTask(image2).execute(url[1]);
        new DownImgAsyncTask(image3).execute(url[2]);

        image1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

            }
        });

        image1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

            }
        });

        image1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){

            }
        });

        button.setOnClickListener(new Button.OnClickListener(){
            public void onClick(View v) {
                //httpRequests
            }
        });
    }

    public int addPerson(String signTag){
        String img_address = imgUrl;
        String person_name = "faniceice";
        String tag = signTag;
        int flag = 0;

        try{
            result1 = httpRequests.detectionDetect(new PostParameters().setUrl("http://115.29.109.27/faceTestImg/16.jpg"));

            JSONObject person_list = httpRequests.infoGetPersonList();

            //搜索是否有重名
            for(int i = 0; i < person_list.getJSONArray("person").length(); i++){
                if(person_name.compareTo(person_list.getJSONArray("person").getJSONObject(i).getString("person_name")) == 0){
                    flag = 1;
                }
            }

            if(flag == 0)
                httpRequests.personCreate(new PostParameters().setPersonName(person_name));
            //加图片
            httpRequests.personAddFace(new PostParameters().setPersonName(person_name).setFaceId(
                    result1.getJSONArray("face").getJSONObject(0).getString("face_id")));

            httpRequests.personSetInfo(new PostParameters().setPersonName(person_name).setTag(tag));

            //add faceset
            httpRequests.facesetAddFace(new PostParameters().setFacesetName("home").setFaceId(
                    result1.getJSONArray("face").getJSONObject(0).getString("face_id")));

            //train
            httpRequests.trainVerify(new PostParameters().setPersonName(person_name));
            httpRequests.trainSearch(new PostParameters().setFacesetName("home"));

            flag = 1;
            return flag;

        }catch (FaceppParseException e){
            e.printStackTrace();
        }catch (Exception e){
            e.printStackTrace();
        }

        return flag;
    }

    public void three(){
        String img_address = imgUrl;
        String person_name = "faniceice";

        String [] return_person_name = new String[3];
        String [] return_person_tag = new String[3];
        String [] return_person_id = new String[3];
        int flag = 0;

        try {
            //train
//            httpRequests.trainVerify(new PostParameters().setPersonName(person_name));
            httpRequests.trainSearch(new PostParameters().setFacesetName("home"));

            result2 = httpRequests.detectionDetect(new PostParameters().setUrl(img_address));
            System.out.println(result2);
            System.out.println(result2.getJSONArray("face").length());

            //JSONArray person_list = httpRequests.infoGetPersonList().getJSONArray("person");
            for(int i = 0; i < result2.getJSONArray("face").length(); i++){
                String result_faceid = "";
                double similarity = 0;
                //搜索相似人脸
                JSONObject response_person_list = httpRequests.recognitionSearch(new PostParameters().setFacesetName("home").setKeyFaceId(
                        result2.getJSONArray("face").getJSONObject(0).getString("face_id")));

                System.out.println(response_person_list);

                //返回3张相似人脸遍历
                JSONArray result_face_list = response_person_list.getJSONArray("candidate");
                for(int j = 0; j < 3; j++) {
                    JSONObject result_face = result_face_list.getJSONObject(j);
                    result_faceid = result_face.getString("face_id");
                    similarity = result_face.getDouble("similarity");
                    if(similarity > 60){
                        JSONObject result_person = httpRequests.infoGetFace(
                                new PostParameters().setFaceId(result_faceid)).getJSONArray("face_info").getJSONObject(0);
//                        return_person_name[j] = result_person.getString("person_name");
//                        return_person_tag[j] = result_person.getString("tag");
//                        return_person_id[j] = result_person.getString("person_id");
                        url[j] = result_person.getString("url");
                        flag = 1;
                    }
                    else{
                        return_person_name = null;
                        return_person_tag = null;
                        flag = 0;
                    }
                }
            }
        } catch(FaceppParseException e) {
            e.printStackTrace();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private Bitmap getImageBitmap(String url){
        URL imageUrl = null;
        Bitmap bitmap = null;
        try {
            imageUrl = new URL(url);
            HttpURLConnection conn = (HttpURLConnection)imageUrl.openConnection();
            conn.setDoInput(true);
            conn.connect();
            InputStream is = conn.getInputStream();
            bitmap = BitmapFactory.decodeStream(is);
            is.close();
        } catch (MalformedURLException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }catch(IOException e){
            e.printStackTrace();
        }
        return bitmap;
    }

    class DownImgAsyncTask extends AsyncTask<String, Void, Bitmap> {
        ImageView image;

        public DownImgAsyncTask(ImageView imageView){
            image = imageView;
        }
        @Override
        protected void onPreExecute() {
            // TODO Auto-generated method stub
            super.onPreExecute();
        }

        @Override
        protected Bitmap doInBackground(String... params) {
            // TODO Auto-generated method stub
            Bitmap b = getImageBitmap(params[0]);
            return b;
        }

        @Override
        protected void onPostExecute(Bitmap result) {
            // TODO Auto-generated method stub
            super.onPostExecute(result);
            if(result!=null){
                image.setImageBitmap(result);
            }
        }
    }
}
