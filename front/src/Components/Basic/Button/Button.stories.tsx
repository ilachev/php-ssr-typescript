import React from "react";
import { Button } from ".";
import { Stack } from "../Stack";

export default {
    title: "Basic/Button",
    component: Button,
};

// replace the text inside with Text variants when available
export const Basic = () => <Button>Сохранить</Button>;

export const Variants = () => (
    <Stack direction="vertical" gap={4} style={{ width: 200 }}>
        <Button variant="primary">Сохранить</Button>
        <Button variant="secondary">Назад</Button>
        <Button variant="link">Перейти</Button>
        <Button variant="danger">Отмена</Button>
    </Stack>
);

export const Disabled = () => (
    <Stack direction="vertical" gap={4} style={{ width: 200 }}>
        <Button disabled variant="primary">
            Сохранить
        </Button>
        <Button disabled variant="secondary">
            Назад
        </Button>
        <Button disabled variant="link">
            Перейти
        </Button>
        <Button disabled variant="danger">
            Отмена
        </Button>
    </Stack>
);

export const Loading = () => (
    <Stack direction="vertical" gap={4} style={{ width: 200 }}>
        <Button loading variant="primary">
            Отмена
        </Button>
        <Button loading variant="secondary">
            Отмена
        </Button>
        <Button loading variant="link">
            Отмена
        </Button>
        <Button loading variant="danger">
            Отмена
        </Button>
    </Stack>
);
