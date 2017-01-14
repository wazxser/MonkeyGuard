package com.example.moon.monkeyguard;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;

public class NotificationBase extends AppCompatActivity{
    public NotificationManager mNotificationManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        super.onCreate(savedInstanceState);
        initService();
    }

    private void initService() {
        mNotificationManager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
    }

    public void clearNotify(int notifyId){
        mNotificationManager.cancel(notifyId);//删除一个特定的通知ID对应的通知
    }

    public void clearAllNotify() {
        mNotificationManager.cancelAll();// 删除你发的所有通知
    }

    public PendingIntent getDefalutIntent(int flags){
        PendingIntent pendingIntent= PendingIntent.getActivity(this, 1, new Intent(), flags);
        return pendingIntent;
    }
}
