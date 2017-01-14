package com.example.moon.monkeyguard;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.sql.Connection;

import com.facepp.error.FaceppParseException;
import com.facepp.http.HttpRequests;
import com.facepp.http.PostParameters;
import com.mysql.jdbc.Driver;

import org.apache.http.HttpRequest;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class MarkActivity extends AppCompatActivity {
    private ImageView image = null;
    private EditText editText = null;
    private TextView signText = null;
    final private Button button = null;
    private TextView text1 = null;
    private TextView text2 = null;

    private Bitmap data = null;
    private String imgUrl = "nulll";
    private String img = null;
    private HttpRequests httpRequests;
    private JSONObject result0 = null;
    private JSONObject result1 = null;
    private JSONObject result2 = null;

    boolean success = false;

    private Handler imgHandler = null;

    String return_person_name = "";
    String return_person_tag = "";
    String return_person_id = "";
    double similarity = 0;
    int flag = 0;

    Button resign = null;

    private Handler mhandler = null;
    private Handler ahandler = null;
    int faceLength;

    public void setUrl(String imgUrl){
        this.imgUrl = imgUrl;
    }

    public void setData(Bitmap data){
        this.data = data;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_image);

        httpRequests = new HttpRequests("c99a07af30ed83c07757b9bec46e8b8b", "K8F1T3lzc8WLW5NEJS-wWCz6mJ7PN5Rw", true, true);

        Intent intent = getIntent();
        imgUrl = intent.getStringExtra("imgUrl");

        System.out.println("路径" + imgUrl);

        image = (ImageView)findViewById(R.id.image);
        signText = (TextView)findViewById(R.id.sign);
        final Button button = (Button)findViewById(R.id.ok);
        final EditText editText = (EditText)findViewById(R.id.edit);
        text1 = (TextView)findViewById(R.id.text1);
        text2 = (TextView)findViewById(R.id.text2);
        resign = (Button)findViewById(R.id.biaoji);

        image.setVisibility(View.INVISIBLE);
        button.setVisibility(View.INVISIBLE);
        editText.setVisibility(View.INVISIBLE);
        resign.setVisibility(View.INVISIBLE);

        if(!(imgUrl.equals("nulll"))){
            image.setVisibility(View.VISIBLE);
            img = imgUrl;
            System.out.println("data");
            new DownImgAsyncTask().execute(img);

            mhandler = new Handler(){
                public void handleMessage(Message msg){
                    if(msg.what == 9874){
                        System.out.println("9874");
                        signText.setVisibility(View.INVISIBLE);
                        text1.setText("经检测，该人员为"+ return_person_tag);
                        text2.setText("相似度为" + similarity);
                        resign.setVisibility(View.VISIBLE);
                        resign.setOnClickListener(new View.OnClickListener(){
                            @Override
                            public void onClick(View v){
                                resign.setVisibility(View.INVISIBLE);
                                button.setVisibility(View.VISIBLE);
                                editText.setVisibility(View.VISIBLE);
                                button.setOnClickListener(new View.OnClickListener(){
                                    @Override
                                    public void onClick(View v){
                                        String addTag = editText.getText().toString();
                                        ahandler = new Handler() {
                                            public void handleMessage(Message mess) {
                                                if (mess.what == 2222) {

                                                }
                                            }
                                        };
                                        addPerson(addTag);
                                        Toast.makeText(getApplicationContext(), "添加成功",
                                                Toast.LENGTH_SHORT).show();

                                        Thread thredRemove = new Thread(new Runnable() {
                                            @Override
                                            public void run() {
                                                try{
                                                    httpRequests.personRemoveFace(new PostParameters().setPersonName(return_person_name).setFaceId(
                                                            result0.getJSONArray("face").getJSONObject(faceLength - 1).getString("face_id")));
                                                    httpRequests.facesetRemoveFace(new PostParameters().setFacesetName("home").setFaceId(
                                                            result0.getJSONArray("face").getJSONObject(faceLength - 1).getString("face_id")));
                                                }
                                                catch (JSONException e){
                                                    e.printStackTrace();
                                                }
                                                catch (FaceppParseException e){
                                                    e.printStackTrace();
                                                }
                                            }
                                        });
                                        thredRemove.start();
                                    }
                                });
                            }
                        });
                    }
                    else if(msg.what == 9876){
                        System.out.println("9876");
                        signText.setText("陌生人来访");
                        button.setVisibility(View.VISIBLE);
                        editText.setVisibility(View.VISIBLE);
                        button.setOnClickListener(new View.OnClickListener(){
                            @Override
                            public void onClick(View v){
                                String addTag = editText.getText().toString();
                                System.out.println("bvdibvisdbivbidbjvd");
                                ahandler = new Handler() {
                                    public void handleMessage(Message mess) {
                                        if (mess.what == 2222){

                                        }
                                    }
                                };
                                addPerson(addTag);
                                Toast.makeText(getApplicationContext(), "添加成功",
                                        Toast.LENGTH_SHORT).show();
                            }
                        });
                    }
                }
            };
            most();
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
                System.out.println("result");
                image.setImageBitmap(result);
            }
        }
    }

    public void most(){
        Thread thread1 = new Thread(new Runnable() {
            @Override
            public void run() {
                try {
                    System.out.println("most");
                    //train
                   // httpRequests.trainVerify(new PostParameters().setPersonName(person_name));

                    httpRequests.trainSearch(new PostParameters().setFacesetName("home"));

                    result0 = httpRequests.detectionDetect(new PostParameters().setUrl(img));
                    //JSONArray person_list = httpRequests.infoGetPersonList().getJSONArray("person");
                    for(int i = 0; i < result0.getJSONArray("face").length(); i++){
                        JSONObject response_person_list = httpRequests.recognitionSearch(new PostParameters().setFacesetName("home").setKeyFaceId(
                                result0.getJSONArray("face").getJSONObject(0).getString("face_id")));

                        System.out.println("person list: " + response_person_list);
                        if(response_person_list.getJSONArray("candidate").length() != 0){
                            JSONObject result_face = response_person_list.getJSONArray("candidate").getJSONObject(0);

                            String result_faceid = result_face.getString("face_id");
                            similarity = result_face.getDouble("similarity");

                            if(similarity > 80){
                                JSONObject result_person = httpRequests.infoGetFace(
                                        new PostParameters().setFaceId(result_faceid)).getJSONArray("face_info").getJSONObject(0).getJSONArray("person").getJSONObject(0);
                                return_person_name = result_person.getString("person_name");
                                return_person_tag = result_person.getString("tag");
                                return_person_id = result_person.getString("person_id");

                                httpRequests.personAddFace(new PostParameters().setPersonName(return_person_name).setFaceId(
                                        result0.getJSONArray("face").getJSONObject(i).getString("face_id")));

                                faceLength = result0.getJSONArray("face").length();

                                //add faceset
                                httpRequests.facesetAddFace(new PostParameters().setFacesetName("home").setFaceId(
                                        result0.getJSONArray("face").getJSONObject(0).getString("face_id")));

                                flag = 1;
                                mhandler.sendEmptyMessage(9874);
                            }
                            else{
                                System.out.println("不相似");
                                return_person_name = null;
                                return_person_tag = null;
                                flag = 0;
                                mhandler.sendEmptyMessage(9876);
                            }

                            System.out.println("perosn name: " + return_person_name);
                            System.out.println("person tag: " + return_person_tag);
                            System.out.println("person id: " + return_person_id);
                            System.out.println("similarity: " + similarity);
                        }
                        else{
                            System.out.println("不相似");
                            return_person_name = null;
                            return_person_tag = null;
                            flag = 0;
                            mhandler.sendEmptyMessage(9876);
                        }

                    }
                } catch(FaceppParseException e) {
                    e.printStackTrace();
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        });

        thread1.start();
    }

    public void addPerson(String signTag){
        final String addTag = signTag;
        Thread thread2 = new Thread(new Runnable() {
            @Override
            public void run() {
                String img_address = img;
              //  String person_name = "faniceice";
                int flag = 0;

                try{
                    result1 = httpRequests.detectionDetect(new PostParameters().setUrl(img));

                    JSONObject person_list = httpRequests.infoGetPersonList();

                    System.out.println(person_list);

                    int number = person_list.getJSONArray("person").length();
                    int num = Integer.parseInt(person_list.getJSONArray("person").getJSONObject(number - 1).getString("person_name"));
                    for(int i = 0; i < number; i++){
                        int a = Integer.parseInt(person_list.getJSONArray("person").getJSONObject(i).getString("person_name"));
                        if( a > num){
                            num = a;
                        }
                    }
                    num = num + 1;

//                    //搜索是否有重名
//                    for(int i = 0; i < person_list.getJSONArray("person").length(); i++){
//                        if(person_name.compareTo(person_list.getJSONArray("person").getJSONObject(i).getString("person_name")) == 0){
//                            flag = 1;
//                        }
//                    }

                    System.out.println(num);
                    if(flag == 0)
                        httpRequests.personCreate(new PostParameters().setPersonName(String.valueOf(num)));
                    //加图片
                    httpRequests.personAddFace(new PostParameters().setPersonName(String.valueOf(num)).setFaceId(
                            result1.getJSONArray("face").getJSONObject(0).getString("face_id")));

                    httpRequests.personSetInfo(new PostParameters().setPersonName(String.valueOf(num)).setTag(addTag));

                    //add faceset
                    httpRequests.facesetAddFace(new PostParameters().setFacesetName("home").setFaceId(
                            result1.getJSONArray("face").getJSONObject(0).getString("face_id")));

                    //train
                    httpRequests.trainVerify(new PostParameters().setPersonName(String.valueOf(num)));
                    httpRequests.trainSearch(new PostParameters().setFacesetName("home"));

                    ahandler.sendEmptyMessage(2222);
                }catch (FaceppParseException e){
                    e.printStackTrace();
                }catch (Exception e){
                    e.printStackTrace();
                }
            }
        });

        thread2.start();
    }

    public void three(){
        String img_address = "http://imgsrc.baidu.com/forum/pic/item/0788a81cd33483db87d6b686.jpg";
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
                                new PostParameters().setFaceId(result_faceid)).getJSONArray("face_info").getJSONObject(0).getJSONArray("person").getJSONObject(0);
                        return_person_name[j] = result_person.getString("person_name");
                        return_person_tag[j] = result_person.getString("tag");
                        return_person_id[j] = result_person.getString("person_id");
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
}